<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repository\OrdersRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $ordersRepository;

    public function __construct(OrdersRepositoryInterface $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function index()
    {
        $orders = $this->ordersRepository->getAll();

        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        $order = $this->ordersRepository->show($id);

        return new OrderResource($order);
    }

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
