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

    public function index()
    {
        $products = $this->productRepository->getAll();
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $input = $request->only('title', 'description', 'image', 'price');
        $product = $this->productRepository->store($input);

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $product = $this->productRepository->show($id);
        return new ProductResource($product);
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();
        $product = $this->productRepository->update($input,$id);
        return response(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        $this->productRepository->destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
