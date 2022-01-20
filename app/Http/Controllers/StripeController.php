<?php

namespace App\Http\Controllers;

use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StripeController extends Controller
{
    protected $stripe;

    public function __construct(StripeService $stripe)
    {
        $this->stripe = $stripe;
    }

    public function payStripe(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'card_no' => 'required',
                'expiry_month' => 'required|digits:2',
                'cvc' => 'required|numeric|digits:3',
                'expiry_year' => 'required|numeric|digits:4',
            ]);

            if ($validator->fails()) {
                ($errors = $validator->errors());
            }

            $stripe = StripeService::payStripe($request);
            if ($stripe) {
                return response()->json(['success' => 'Payment Success!']);
            } else {
                return response()->json(['error' => 'Something went to wrong.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json([

                'errors' => [$errors, 'samo' => $e->getMessage()],
            ], 400);
        }
    }

    public function myTransaction()
    {
        return $this->stripe->myTransaction();
    }


}

