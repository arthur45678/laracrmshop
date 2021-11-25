<?php

namespace App\Repository;

interface CheckoutRepositoryInterface
{
    /**
     * @return object
     */
    public function getOrders(): object;
}
