<?php

namespace App\Repository;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
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
     * @param array $data
     * @param $id
     * @return object
     */
    public function update(array $data, $id): object;

    /**
     * @param $id
     * @return object
     */
    public function destroy($id): object;
}
