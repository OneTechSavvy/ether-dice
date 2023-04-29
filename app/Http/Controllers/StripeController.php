<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        // Set your Stripe API keys
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Calculate the total amount with fee included
        $amount = $request->input('amount') * 1.02; // add $2 fee

        // Convert the amount from dollars to cents
        $amount_cents = $amount * 100;

        // Create a new price for the deposit
        $price = \Stripe\Price::create([
            'unit_amount' => $amount_cents,
            'currency' => 'usd',
            'product_data' => [
                'name' => 'Deposit',
            ],
        ]);

        // Create a new Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Deposit',
                        'description' => 'Deposit funds to your account',
                    ],
                    'unit_amount' => $amount_cents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('deposit.success'),
            'cancel_url' => route('deposit.cancel'),
        ]);

        // Redirect the user to the Stripe Checkout page
        return redirect()->away($session->url);
    }



    public function depositSuccess(Request $request)
    {
        // Get the user who made the deposit
        $user = auth()->user();
    
        // Get the amount deposited
        $amount = $request->query('amount');
    
        // Convert the amount to coins based on the USD to coin rate
        $coins = $amount * 2;
    
        // Update the user's coin balance
        $user->coins += $coins;
        $user->save();
    
        // Redirect to a success page or show a success message
        return redirect()->route('home')->with('success', 'Deposit successful. ' . $coins . ' coins have been added to your balance.');
    }

    public function depositCancel()
    {
        // Handle canceled deposit
        // Redirect to a cancel page or show a cancel message
    }
}