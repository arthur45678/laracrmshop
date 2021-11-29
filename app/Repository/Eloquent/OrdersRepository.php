<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repository\OrdersRepositoryInterface;
use Illuminate\Support\Collection;

class OrdersRepository extends BaseRepository implements  OrdersRepositoryInterface
{
    protected $orderItem;
    /**
     * UserRepository constructor.
     *
     * @param Order $model
     */
    public function __construct(Order $model, OrderItem $orderItem)
    {
        parent::__construct($model);
        $this->orderItem = $orderItem;
    }

    /**
     * @return Collection
     */
    public function getAll(): object{

        return $this->model->with('orderItems')->paginate();
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
     * @param array $data
     * @return object
     */
    public function storeOrderProduct(array $data) : object
    {
        return $this->orderItem->create($data);
    }



    /**
     * @param $id
     * @return object
     */
    public function show($id): object{
        return $this->model->with('orderItems')->find($id);
    }


    /**
     * @return mixed
     */
    public function export(){

        $data = [];

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=orders.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];


        $callback = function () {
            $orders = Order::all();
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Email', 'Product Title', 'Price', 'Quantity']);

            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);


            }

            fclose($file);
        };

        $data['headers'] = $headers;
        $data['callback'] = $callback;

        return $data;


    }

    /**
     * @return Collection
     */
    public function chart(): Collection{
        return $this->model->query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, SUM(order_items.price * order_items.quantity) as sum")
            ->groupBy('date')
            ->get();
    }


}
