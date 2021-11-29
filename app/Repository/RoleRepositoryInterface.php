<?php

namespace App\Repository;

use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
    /**
     * @return object
     */
    public function getAll(): object;

    /**
     * @param array $data
     * @return object
     */
    public function store(array  $data): object;

    /**
     * @param $id
     * @return object
     */
    public function show($id): object;

    /**
     * @param array $name
     * @param array $permissions
     * @param $id
     * @return object
     */
    public function update(array $name, array $permissions, $id);


    /**
     * @param $id
     * @return object
     */
    public function destroy($id): object;

}
