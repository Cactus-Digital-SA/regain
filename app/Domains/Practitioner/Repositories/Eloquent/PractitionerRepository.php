<?php

namespace App\Domains\Practitioner\Repositories\Eloquent;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Practitioner\Models\Practitioner;
use App\Domains\Practitioner\Repositories\Eloquent\Models\Practitioner as EloquentPractitioner;
use App\Domains\Practitioner\Repositories\PractitionerRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Nette\NotImplementedException;
use Yajra\DataTables\DataTables;

class PractitionerRepository implements PractitionerRepositoryInterface
{
    public function getById(string $id): ?Practitioner
    {
        $practitionerData = EloquentPractitioner::where('id', '=', $id)->with(['user', 'region'])->get();

        return ObjectSerializer::deserialize($practitionerData?->toJson() ?? "{}", Practitioner::class, 'json');
    }

    public function getByUserId(string $userId): ?Practitioner
    {
        $practitionerData = EloquentPractitioner::whereIn('user_id', static function ($query) use ($userId) {
            $query->select('id')
                  ->from('users')
                  ->where('id', "=", $userId);
        })->with(['user', 'region'])->get()->first();

        return ObjectSerializer::deserialize($practitionerData?->toJson() ?? "{}", Practitioner::class, 'json');
    }

    public function store(CactusEntity $entity): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        throw new NotImplementedException();
    }

    /**
     * @inheritDoc
     */
    public function getTableColumns(): array
    {
        return [
            'id'         => [
                'name'       => 'id',
                'table'      => 'practitioners.id',
                'searchable' => 'false',
                'sortable'   => 'true'
            ],
            'name'       => [
                'name'       => 'Practitioner Name',
                'table'      => 'users.name',
                'searchable' => 'false',
                'sortable'   => 'false'
            ],
            'region'     => [
                'name'       => 'Region',
                'table'      => 'region.name',
                'searchable' => 'false',
                'sortable'   => 'false'
            ],
            'registered' => [
                'name'       => 'Registered',
                'table'      => 'users.created_at',
                'searchable' => 'false',
                'sortable'   => 'false'
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        $user = User::find($userId);

        $data = null;
        if ($user->isPractitioner()) {
        } elseif ($user->isRegainUser()) {
            $data = EloquentPractitioner::get()->load(['user', 'region']);
        } else {
            throw new UnauthorizedException();
        }

        return DataTables::of($data)
                         ->editColumn('id', function ($data) {
                             return '#OP' . $data->user_id;
                         })
                         ->editColumn('name', function ($data) use ($user) {
                             return e($data->user->name);
                         })
                         ->editColumn('region', function ($data) {
                             return $data?->region?->name ?? ' - ';
                         })
                         ->editColumn('registered', function ($data) {
                             return $data?->user?->created_at?->format('d-m-Y') ?? ' - ';
                         })
                         ->makeHidden(['created_at', 'updated_at', 'deleted_at'])
                         ->rawColumns(['name'])
                         ->toJson();
    }
}
