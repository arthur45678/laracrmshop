<?php

namespace App\Repository;
use Illuminate\Support\Collection;

interface OrdersRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): object;

    /**
     * @param $id
     * @return object
     */
    public function show($id): object;

    /**
     * @param array $data
     * @return object
     */
    public function store(array $data) : object;

    /**
     * @param array $data
     * @return object
     */
    public function storeOrderProduct(array $data) : object;
    /**
     * @return mixed
     */
    public function export();

    /**
     * @return Collection
     */
    public function chart(): Collection;

}
