<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Models\User;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    /**
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * @return object
     */
    public function getAll(): object
    {
        return $this->model->paginate();

    }

    /**
     * @param array $data
     * @return object
     */
    public function store(array $data): object
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @return object
     */
    public function show($id): object
    {
        return $this->model::find($id);
    }


    /**
     * @param array $data
     * @param $id
     * @return object
     */
    public function update(array $data, $id): object
    {
        $product = $this->model->find($id);
        $item = $product->update($data);
        return $item;

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
