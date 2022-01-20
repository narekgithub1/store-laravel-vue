<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use function Symfony\Component\Translation;


class OrdersController extends Controller
{
    protected $orders;

    public function __construct(OrderService $orders)
    {
        $this->orders = $orders;
    }

    public function showMyOrders()
    {
        return $this->orders->showMyOrders();
    }

    public function create(Request $request, $id)
    {
        return $this->orders->create($request, $id);
    }

    public function oneOrder($id)
    {
        return $this->orders->oneOrder($id);
    }

    public function updateOrder($id, Request $request)
    {
        return $this->orders->updateOrder($id, $request);
    }

    public function delete($id)
    {
        return $this->orders->delete($id);
    }
}


