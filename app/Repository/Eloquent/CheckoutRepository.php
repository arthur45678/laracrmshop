<?php

namespace App\Repository\Eloquent;

use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use App\Repository\CheckoutRepositoryInterface;

class CheckoutRepository extends  BaseRepository implements CheckoutRepositoryInterface
{

    /**
     * @return object
     */
    public function getOrders(): object{
        $data = [];
        //   $data['users'] = $users = User::where(['role_id' => 3])->get();
        $data['users'] =  UserResource::where(['role_id' => 3])->collection(User::with('role')->paginate());;
        //  $data['products'] = $products = Product::all();
        $data['products'] = ProductResource::collection(Product::paginate());
    }

}
