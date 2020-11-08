<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * Show the orders.
     *
     * @return View
     */
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $line_items = array();
        $id = rand(1,1000);
        $line_items[] = [
            'name' => 'Order ' . $id,
            'amount' => number_format((float)$request->cart['total'], 2, '', ''),
            'quantity' => 1,
            'currency' => 'usd',
        ];
        //dd($request->cart);
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => env('APP_URL') . '/confirmation-order?reference='.$id,
            'cancel_url' => env('APP_URL') . '/?payment=cancel',
        ]);
        if (isset($session->id)){
            //DB::beginTransaction();
            //save  session data
            //DB::commit();
            return response()->json(['id' => $session->id]);
        }
        else
            return response()->json(['message' => 'fail to create session'], 500);
    }

    public function confirmarionOrder(){
        return view('confirmationOrder');
    }
}
