<?php

namespace App\Repository;

interface UserRepositoryInterface
{
    /**
     * @return object
     */
    public function getAll(): object;

    /**
     * @param array $data
     * @return object
     */
    public function store(array $data): object;

    /**
     * @param $id
     * @return object
     */
    public function show($id): object;

    /**
     * @param array $input
     * @param $id
     * @return object
     */
    public function update(array $input, $id): object;

    /**
     * @param $id
     * @return object
     */
    public function destroy($id): object;

}
