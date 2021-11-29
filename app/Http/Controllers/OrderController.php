<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Repository\OrdersRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    protected $ordersRepository;

    public function __construct(OrdersRepositoryInterface $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }


    /**
     * @OA\Get(path="/api/orders",
     *   security={{"bearerAuth":{}}},
     *   tags={"Orders"},
     *   @OA\Response(response="200",
     *     description="Order Collection",
     *   )
     * )
     */
    public function index()
    {
        $orders = $this->ordersRepository->getAll();

        return OrderResource::collection($orders);
    }

    /**
     * @OA\Get(path="/api/orders/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Orders"},
     *   @OA\Response(response="200",
     *     description="User",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Order ID",
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
        $order = $this->ordersRepository->show($id);

        return new OrderResource($order);
    }


    /**
     * @OA\Post(
     *   path="/api/orders",
     *   security={{"bearerAuth":{}}},
     *   tags={"Orders"},
     *   @OA\Response(response="201",
     *     description="Order Create",
     *   )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->only('address', 'user_id');
        $product = $this->ordersRepository->store($input);

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *   path="/api/storeOrderProduct",
     *   security={{"bearerAuth":{}}},
     *   tags={"Orders"},
     *   @OA\Response(response="201",
     *     description="Order Product Create",
     *   )
     * )
     */
    public function storeOrderProduct(Request $request)
    {
        $input = $request->all();
        $product = $this->ordersRepository->store($input);

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(path="/api/export",
     *   security={{"bearerAuth":{}}},
     *   tags={"Orders"},
     *   @OA\Response(response="200",
     *     description="Order Export",
     *   )
     * )
     */
    public function export()
    {
        $data = $this->ordersRepository->export();

        return \Response::stream($data['callback'], 200, $data['headers']);
    }

    public function chart()
    {
        return $this->ordersRepository->chart();
    }
}
