<?php

namespace App\Repository\Eloquent;

use App\Models\Role;
use App\Repository\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * @return object
     */
    public function getAll(): object
    {
        return $this->model::all();
    }

    /**
     * @param array $data
     * @return object
     */
    public function store(array $data): object
    {
        $role = Role::create($data['name']);

        $role->permissions()->attach($data['permissions']);

        return $role->load('permissions');
    }

    /**
     * @param $id
     * @return object
     */
    public function show($id): object
    {
        return $this->model::with('permissions')->find($id);
    }

    /**
     * @param array $name
     * @param array $permissions
     * @param $id
     * @return object
     */
    public function update(array $name, array $permissions, $id): object
    {
        $role = Role::find($id);

        $role->update($request->only('name'));

        $role->permissions()->sync($request->input('permissions'));

        return $role->load('permissions');

    }

    /**
     * @param $id
     * @return object
     */
    public function destroy($id): object
    {
        return $this->model::destroy($id);
    }

}
