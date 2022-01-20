<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderService
{

    public function showMyOrders()
    {
        $userId = auth()->user()->id;
        $myOrders = Orders::where('buyer_id', '=', $userId)
            ->where('status', '=', 'unpaid')
            ->with('books')
            ->get();
        return response()->json($myOrders);
    }

    public static function create(Request $request, $id)
    {
        try {
            $orderBook = Book::find($id);
            $data = [
                'product_id' => $orderBook->id,
                'amount' => $orderBook->amount,
                'count' => $request->count,
                'seller_id' => $orderBook->seller_id,
                'buyer_id' => auth()->user()->id,
                'status' => $request->status
            ];
//            $newOrderBooksCount = $orderBook->count - $request->count;
//            $orderBook->update([
//                'count' => $newOrderBooksCount
//            ]);

            if (Orders::where('product_id', $id)
                    ->where('status', '=', 'unpaid')
                    ->count() > 0) {
                $x = Orders::where('product_id', $id)
                    ->first();

                $x->update([
                    'count' => $request->count + $x->count
                ]);
            } else {
                $order = Orders::create($data);
                return response()->json($order, 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function oneOrder($id)
    {
        return response()->json(Orders::find($id));
    }

    public function updateOrder($id, Request $request)
    {
        $order = Orders::findOrFail($id);
        $order->update([
            'count' => $request->count
        ]);
        return response()->json($order);
    }

    public function delete($id)
    {
        Orders::findOrFail($id)->delete();
        return response([
            "message" => "Book successfully deleted"
        ]);
    }


}
