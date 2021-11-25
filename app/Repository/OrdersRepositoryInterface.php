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
     * @return mixed
     */
    public function export();

    /**
     * @return Collection
     */
    public function chart(): Collection;

}
