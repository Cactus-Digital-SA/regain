<?php

namespace App\Domains\Auth\Repositories\Eloquent;

use App\Domains\Auth\Repositories\Eloquent\Models\Permission as EloquentPermission;
use App\Domains\Auth\Repositories\Eloquent\Models\Role as EloquentRole;
use App\Domains\Auth\Repositories\Eloquent\Models\User as EloquentUser;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Exceptions\GeneralException;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use App\Domains\Auth\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Throwable;
use Yajra\DataTables\DataTables;

class EloqUserRepository implements UserRepositoryInterface
{
    private EloquentUser $model;

    public function __construct(EloquentUser $user)
    {
        $this->model = $user;
    }

    public function getAuthUser(): ?User
    {
        $user = Auth::user();
        $user->makeVisible('two_factor_secret');
        $user->makeVisible('two_factor_confirmed');
        $user->makeVisible('two_factor_recovery_codes');
        if ($user->two_factor_secret && $user->two_factor_confirmed) {
            $user->twoFactorQrCodeSvg = $user->twoFactorQrCodeSvg();
        }

        return ObjectSerializer::deserialize($user->toJson() ?? "{}", User::class, 'json');
    }

    public function getById(string $id): ?User
    {
        $user = $this->model->with('roles')->with('permissions')->findOrFail($id);
        $user->makeVisible('two_factor_secret');

        return ObjectSerializer::deserialize($user->toJson() ?? "{}", User::class, 'json');
    }

    /**
     * @param string $roleId
     * @return User[]
     */
    public function getByRoleId(string $roleId): array
    {
        $users = $this->model->whereHas('roles', function ($query) use ($roleId) {
            $query->where('id', $roleId);
        })->get();

        return ObjectSerializer::deserialize($users->toJson() ?? "{}", 'array<' . User::class . '>', 'json');
    }

    /**
     * @throws GeneralException
     */
    public function store(User|CactusEntity $entity): ?User
    {
        DB::beginTransaction();

        try {
            $pass = $entity->getPassword();
            if (!$pass) {
                $pass = Str::random(12);
            }

            $user = $this->model::create([
                'name'              => $entity->getName() ?? null,
                'email'             => $entity->getEmail() ?? null,
                'password'          => bcrypt($pass) ?? null,
                'email_verified_at' => $entity->getEmailVerifiedAt() ? now() : null,
                'active'            => $entity->getActive() ?? true,
            ]);

            $roles = [];
            foreach ($entity->getRoles() as $role) {
                $roles[] = EloquentRole::find($role);
            }

            $user->syncRoles($roles ?? []);

            foreach ($entity->getPermissions() as $permission) {
                $permissions[] = EloquentPermission::find($permission);
            }

            $user->syncPermissions($permissions ?? []);

            //todo send email notification
//        $user->notify(new UserRegistration($pass));
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating this user. Please try again.'));
        }

        DB::commit();

        return ObjectSerializer::deserialize($user->toJson() ?? "{}", User::class, 'json');
    }

    /**
     * @throws GeneralException
     */
    public function update(User|CactusEntity $entity, string $id, bool $updateRole = false): ?User
    {
        DB::beginTransaction();

        try {
            $user = EloquentUser::find($id);

            $user->update([
                'name'              => $entity->getName(),
                'email'             => $entity->getEmail(),
                'profile_photo_url' => $entity->getProfilePhotoUrl()
            ]);

            if ($updateRole) {
                if (!$user->isMasterAdmin()) {
                    // Replace selected roles/permissions
                    dd($entity->getRoles());
                    foreach ($entity->getRoles() as $role) {
                        $roles[] = EloquentRole::find($role);
                    }

                    $user->syncRoles($roles ?? []);

                    $permissions = [];
                    foreach ($entity->getPermissions() as $permission) {
                        $permissions[] = EloquentPermission::find($permission);
                    }

                    $user->syncPermissions($permissions ?? []);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem updating this user. Please try again.'));
        }

        DB::commit();

        return ObjectSerializer::deserialize($user->toJson() ?? "{}", User::class, 'json');
    }

    public function deleteById(string $id): bool
    {
        $user = EloquentUser::find($id);
        if ($user->id === auth()->id()) {
            return false;
        }

        $user->delete();

        return true;
    }

    /**
     * @throws Throwable
     */
    public function updatePassword(User|CactusEntity $entity, string $userId, mixed $expired): ?User
    {
        $user = EloquentUser::find($userId);

        // Reset the expiration clock
        if ($expired) {
            $user->password_changed_at = now();
        }

        $user->password = bcrypt($entity->getPassword());
        $user->save();

        return ObjectSerializer::deserialize($user->toJson() ?? "{}", User::class, 'json');
    }

    public function updateProfileImage(string $userId, UploadedFile $photo): ?User
    {
        $user = $this->model->find($userId);

        $user?->updateProfilePhoto($photo);

        return ObjectSerializer::deserialize($user->toJson() ?? "{}", User::class, 'json');
    }

    public function deleteProfilePhoto(string $userId): bool
    {
        $user = $this->model->find($userId);
        if ($user) {
            $user->deleteProfilePhoto();

            return true;
        }

        return false;
    }

    public function updateActive(string $userId, bool $active): bool
    {
        if ($active == 0 && (auth()->id() === $userId || $userId == 1 || $userId == 2)) {
            return false;
        }

        $user         = EloquentUser::find($userId);
        $user->active = $active;
        $user->save();

        return true;
    }

    public function restore(string $userId): bool
    {
        $user = EloquentUser::withTrashed()->find($userId);

        return $user->restore();
    }

    public function destroyById(string $userId): bool
    {
        $user = EloquentUser::find($userId);
        if ($user->forceDelete()) {
            return true;
        }

        return false;
    }

    /**
     * @param string|null $searchTerm
     * @param int         $offset
     * @param int         $resultCount number of results per page
     * @return array{data: Collection, count: int} Array contains paginated data and total count.
     */
    public function emailsPaginated(?string $searchTerm, int $offset, int $resultCount): array
    {
        $users = $this->model->select('id', DB::raw('email AS text'));
        if ($searchTerm != null) {
            $users = $users->where('email', 'LIKE', '%' . $searchTerm . '%');
        }

        $users = $users->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'super-admin');
        });

        $users = $users->skip($offset)->take($resultCount)->get('id');

        if ($searchTerm == null) {
            $count = $this->model->count();
        } else {
            $count = $users->count();
        }

        return [
            "data"  => $users,
            "count" => $count
        ];
    }

    /**
     * @param array $filters
     * @return JsonResponse
     * @throws Exception
     */
    public function usersDatatable(array $filters = []): JsonResponse
    {
        $users = EloquentUser::query();
        $users = $users->select('users.*');

        if (isset($filters['status']) && $filters['status'] == '1') {
            $users = $users->onlyTrashed();
        }

        /**
         * Custom Search - Filter in Datatables
         */
        $users = $users
            ->when($filters['active'] !== null, function ($query, $searchTerm) use ($filters) {
                $query->where('users.active', $filters['active']);
            })
            ->when($filters['filterName'], function ($query, $searchTerm) {
                $query->where('users.name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->when($filters['filterUserEmail'], function ($query, $searchTerm) {
                $query->where('users.email', $searchTerm);
            })
            ->when($filters['filterRole'], function ($query, $searchTerm) {
                $query->whereHas('roles', function ($q2) use ($searchTerm) {
                    $q2->where('id', $searchTerm);
                });
            });

        $users = $users->whereHas('roles', function ($q) {
            $q->where('name', '!=', 'super-admin');
        })
                       ->orWhereDoesntHave('roles');

        if ($filters['columnName'] && $filters['columnSortOrder']) {
            $users = $users->orderBy($filters['columnName'], $filters['columnSortOrder']);
        }

        $users = $users->orderBy('users.id', 'desc')
                       ->groupBy('users.id');

        return DataTables::of($users)
                         ->editColumn('roles', function (EloquentUser $user) {
                             $html = "";
                             foreach ($user->roles as $role) {
                                 $html .= '<span class="badge rounded-pill bg-label-primary">';
                                 $html .= $role->name;
                                 $html .= '</span>';
                             }

                             return $html;
                         })
                         ->addColumn('more', function (EloquentUser $user) {
                             return view('backend.auth.users.includes.actions', ['user' => $user])->render();
                         })
                         ->addColumn('restore', function (EloquentUser $user) {
                             return '<form class="revert-form" method="POST" action="' . route('admin.users.restore') . '">
                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                            <input type="hidden" name="revert-id" value="' . $user->id . '"/>
                            <button type="submit" class="revert btn btn-group-sm">
                                <i class="fas fa-clock-rotate-left"></i>
                            </button>
                        </form>';
                         })
                         ->addColumn('online_status', function (EloquentUser $user) {
                             if (Cache::has('user-is-online-' . $user->id)) {
                                 return '<span class="badge rounded-pill bg-label-primary"> Online </span>';
                             } else {
                                 return '<span class="badge rounded-pill bg-label-danger"> Offline </span>';
                             }
                         })
                         ->addColumn('last_login', function (EloquentUser $user) {
                             if ($user->last_login_at) {
                                 return Carbon::parse($user->last_login_at)->diffForHumans();
                             }

                             return ' - ';
                         })
                         ->rawColumns(['roles', 'online_status', 'online_status', 'edit', 'delete', 'more', 'restore'])
                         ->toJson();
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function apiAuthentication(User $user): JsonResponse
    {
        if (Auth::attempt(['email' => $user->getEmail(), 'password' => $user->getPassword()])) {
            $eloquentUser = Auth::user();
            if ($eloquentUser->canApi()):
                $success['token'] = $eloquentUser->createToken('PrivateLessons', ['*'], Carbon::now()->addHours(4))->plainTextToken;

                return response()->json(['success' => $success], 200);
            else:
                return response()->json(['error' => 'Unauthorised'], 401);
            endif;
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * @return JsonResponse
     */
    public function apiLogOut(): JsonResponse
    {
        $eloquentUser = Auth::user();
        $eloquentUser->currentAccessToken()->delete();
        Auth::guard('web')->logout();

        return response()->json(['success' => 'Logged Out'], 200);
    }

    /**
     * @param string $code
     * @return bool
     */
    public function confirmTwoFactorAuth(string $code): bool
    {
        $eloquentUser = Auth::user();

        $codeIsValid = app(TwoFactorAuthenticationProvider::class)
            ->verify(decrypt($eloquentUser->two_factor_secret), $code);

        if ($codeIsValid) {
            $eloquentUser->two_factor_confirmed    = true;
            $eloquentUser->two_factor_confirmed_at = now();
            $eloquentUser->save();

            return true;
        }

        return false;
    }

    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
    }
}
