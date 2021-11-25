<?php

namespace App\Repository\Eloquent;

use App\Models\Permission;
use App\Repository\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{

    /**
     * @param Permission $model
     */
    public function __construct(Permission $model)
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

}
