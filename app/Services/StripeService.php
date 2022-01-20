<?php

namespace App\Services;


use App\Models\Orders;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe;


class StripeService
{
    public static function payStripe(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $response = \Stripe\Token::create(array(
            "card" => array(
                "number" => $request->card_no,
                "exp_month" => $request->expiry_month,
                "exp_year" => $request->expiry_year,
                "cvc" => $request->cvv
            )));

        $charge = Stripe\Charge::create([
            'currency' => 'USD',
            'amount' => $request->total,
            'description' => 'wallet',
            'source' => $response->id
        ]);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $result = $stripe->balanceTransactions->all();

//        Log::info('BUYER_ID - ' . auth()->user()->id);
        foreach ($result->data as $item) {
            $data[] = [
                'type' => $item->type,
                'amount' => $charge->amount,
                'net' => $item->net,
                'fee' => $item->fee,
                'description' => $item->description,
                'status' => $item->status,
                'currency' => $item->currency,
                'buyer_id' => auth()->user()->id
            ];
        }

        Transaction::create($data[0]);
        $order = Orders::find($request->order_id);
        $order->update([
            'status' => 'paid'
        ]);
        if ($charge['status'] == 'succeeded') {
            return true;
        } else {
            return false;
        }
    }

    public function myTransaction()
    {
        $userId = auth()->user()->id;
        $myTransaction = Transaction::where('buyer_id', '=', $userId)->paginate(5);
        return response()->json($myTransaction);
    }


}
