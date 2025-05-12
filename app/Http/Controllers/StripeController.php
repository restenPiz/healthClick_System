<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'currency' => 'required|string',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $lineItems = array_map(function ($item) {
            return [
                'price_data' => [
                    'currency' => request('currency'),
                    'product_data' => ['name' => $item['name']],
                    'unit_amount' => $item['price'] * 100, // MZN em centavos
                ],
                'quantity' => $item['quantity'],
            ];
        }, $validated['items']);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => url('/payment-success'),
            'cancel_url' => url('/payment-cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }
}
