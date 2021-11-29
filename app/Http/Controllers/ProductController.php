<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @OA\Get(path="/api/products",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="200",
     *     description="Product Collection",
     *   )
     * )
     */
    public function index()
    {
        $products = $this->productRepository->getAll();
        return ProductResource::collection($products);
    }

    /**
     * @OA\Post(
     *   path="/api/products",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="201",
     *     description="Product Create",
     *   )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->only('title', 'description', 'image', 'price');
        $product = $this->productRepository->store($input);

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(path="/api/products/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="200",
     *     description="User",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Product ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function show($id)
    {
        $product = $this->productRepository->show($id);
        return new ProductResource($product);
    }

    /**
     * @OA\Put(
     *   path="/api/products/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="202",
     *     description="Product Update",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Product ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function update(Request $request, $id)
    {

        $input = $request->all();
        $product = $this->productRepository->update($input,$id);
        return response(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(path="/api/products/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="204",
     *     description="Product Delete",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Product ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function destroy($id)
    {
        $this->productRepository->destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
