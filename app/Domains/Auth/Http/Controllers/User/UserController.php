<?php

namespace App\Domains\Auth\Http\Controllers\User;

use App\Domains\Auth\Http\Requests\User\CreateUserRequest;
use App\Domains\Auth\Http\Requests\User\DeleteUserRequest;
use App\Domains\Auth\Http\Requests\User\EditUserRequest;
use App\Domains\Auth\Http\Requests\User\ManageUserRequest;
use App\Domains\Auth\Http\Requests\User\ReactiveUserRequest;
use App\Domains\Auth\Http\Requests\User\StoreUserRequest;
use App\Domains\Auth\Http\Requests\User\UpdateUserPasswordRequest;
use App\Domains\Auth\Http\Requests\User\UpdateUserRequest;
use App\Domains\Auth\Services\PermissionService;
use App\Domains\Auth\Services\RoleService;
use App\Domains\Auth\Services\UserService;
use App\Http\Controllers\Controller;
use App\Domains\Auth\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;
    protected RoleService $roleService;
    protected PermissionService $permissionService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     * @param RoleService $roleService
     * @param PermissionService $permissionService
     */
    public function __construct(UserService $userService, RoleService $roleService, PermissionService $permissionService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    private function prepareViewData($request, $status = 0, $active = 1)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => __('locale.Home')], ['name' => __('locale.Users')]
        ];

        $role = $request->input('role');
        $roles = $this->roleService->get();


        return [
            'breadcrumbs' => $breadcrumbs,
            'status' => $status,
            'active' => $active,
            'roles' => $roles,
            'selectedRole' => $role,
        ];
    }

    public function index(ManageUserRequest $request)
    {
        return view('backend.auth.users.index', $this->prepareViewData($request));
    }

    public function deleted(ManageUserRequest $request)
    {
        return view('backend.auth.users.index', $this->prepareViewData($request, 1));
    }

    public function deactivated(ManageUserRequest $request)
    {
        return view('backend.auth.users.index', $this->prepareViewData($request, 0, 0));
    }

    public function create(CreateUserRequest $request)
    {
        return view('backend.auth.users.create')
            ->withRoles($this->roleService->get())
            ->withCategories($this->permissionService->getCategorizedPermissions())
            ->withGeneral($this->permissionService->getUncategorizedPermissions());
    }

    public function store(StoreUserRequest $request)
    {

        $userDTO = new User();
        $userDTO->setName($request['name']);
        $userDTO->setEmail($request['email']);
        $userDTO->setPassword($request['password'] ?? null);
        $userDTO->setEmailVerifiedAt($request['email_verified'] ? now() : null);
        $userDTO->setActive($request['active'] ?? false);
        $userDTO->setRoles($request['roles'] ?? []);
        $userDTO->setPermissions($request['permissions'] ?? []);

        $this->userService->store($userDTO);

        return redirect()->route('admin.users.index')->with('success', 'Ο χρήστης δημιουργήθηκε με επιτυχία');
    }

    public function show(Request $request, string $userId)
    {
        return redirect()->route('admin.users.edit', $userId);
    }

    /**
     * @param EditUserRequest $request
     * @param string $userId
     * @return mixed
     */
    public function edit(EditUserRequest $request, string $userId)
    {
        $cactusUser = $this->userService->getById($userId);

        return view('backend.auth.users.edit')
            ->withUser($cactusUser)
            ->withRoles($this->roleService->get())
            ->withUserRoles($this->roleService->getRolesIdByUserId($userId))
            ->withCategories($this->permissionService->getCategorizedPermissions())
            ->withGeneral($this->permissionService->getUncategorizedPermissions())
            ->withUsedPermissions($this->permissionService->getUserPermissionId($userId));
    }

    public function update(UpdateUserRequest $request, string $userId)
    {
        $userDTO = new User();
        $userDTO->setName($request['name']);
        $userDTO->setEmail($request['email']);
        $userDTO->setRoles($request['roles'] ?? []);
        $userDTO->setPermissions($request['permissions'] ?? []);

        $user = $this->userService->update($userDTO, $userId,true);

        return redirect()->route('admin.users.edit', $user->getId())->with('success', 'Ο χρήστης ενημερώθηκε με επιτυχία');
    }


    public function editPassword(Request $request, string $userId)
    {
        $cactusUser = $this->userService->getById($userId);
        $authUser = $this->userService->getAuthUser();

        return view('backend.auth.users.edit_password')
            ->withAuthUser($authUser)
            ->withUser($cactusUser);
    }
    public function updatePassword(UpdateUserPasswordRequest $request, string $userId)
    {
        $userDTO = new User();
        $userDTO->setPassword($request['password']);
        $this->userService->updatePassword($userDTO, $userId);

        return redirect()->route('admin.users.index')->with('success','Ο κωδικός του χρήστη ενημερώθηκε με επιτυχία');
    }

    public function delete(DeleteUserRequest $request, string $userId)
    {

        $response = $this->userService->deleteById($userId);
        if ($response) {
            return redirect()->route('admin.users.index')->with('success', 'Ο χρήστης διαγράφτηκε με επιτυχία');
        }

        return redirect()->route('admin.users.index')->with('error', 'Ο χρήστης δεν μπόρεσε να διαγραφεί!');
    }

    public function restore(ReactiveUserRequest $request)
    {
        $response = $this->userService->restore($request['revert-id']);
        if ($response) {
            return redirect()->back()->with('success', 'Ο χρήστης επαναφέρθηκε');
        }

        return redirect()->back()->with('danger', 'Δεν έγινε επαναφορά του χρήστη!');
    }

    public function updateActive(ReactiveUserRequest $request, string $userId, bool $active)
    {
        $response = $this->userService->updateActive($userId, $active);

        if (!$response) {
            return redirect()->back()->with('error', 'Δεν μπορείς να απενεργοποιήσεις αυτόν τον χρήστη');
        }

        $message = 'Απενεργοποιήθηκε';
        if ($active) {
            $message = 'Ενεργοποιήθηκε';
        }

        return redirect()->back()->with('success', 'Ο χρήστης ' . $message);
    }

}
