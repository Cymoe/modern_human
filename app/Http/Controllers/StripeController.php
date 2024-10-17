<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Subscription',
                    ],
                    'unit_amount' => 1000, // $10.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function success(Request $request)
    {
        // Handle successful payment
        return view('checkout.success');
    }

    public function cancel()
    {
        // Handle cancelled payment
        return view('checkout.cancel');
    }

    public function showSubscriptionPage()
    {
        // Replace this with your actual Stripe payment link
        $checkoutUrl = 'https://buy.stripe.com/aEU7tX94j02L6Na6oy';
        return view('subscribe', compact('checkoutUrl'));
    }
}
