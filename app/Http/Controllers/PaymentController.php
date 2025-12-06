<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public $stripe;

    public function __construct()
    {
        // Instantiate the Stripe client with the secret key from env
        // Use positional arg for compatibility across PHP versions
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function index()
    {
        return view('payment');
    }

    public function checkout(Request $request)
    {

        // $id = $this->stripe->products->create([
        //     'name' => 'Gold Plan',
        // ])->id;
        // $price = $this->stripe->prices->create([
        //     'unit_amount' => 2000,
        //     'currency' => 'usd',
        //     'product' => $id,
        // ])->id;

        // $coupon = $this->stripe->coupons->create([
        //     'duration' => 'once',
        //     'percent_off' => 36.5,
        //     'redeem_by' => strtotime('2025-11-12 02:16:18'),
        // ]);

        // $promotionCode = $this->stripe->promotionCodes->create([
        //     'promotion' => [
        //         'type' => 'coupon',
        //         'coupon' => $coupon->id,

        //     ],
        // ]);

        $session = $this->stripe->checkout->sessions->create([
            'mode' => 'payment',
            'allow_promotion_codes' => true,

            'line_items' => [
                [
                    //this is created from dashboard

                    'quantity' => 10,
                    'price' => 'price_1SSINmHciNNd805tvp8fDaKq',
                ],
                [

                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'T-shirt',
                            'description' => 'this is a cool t-shirt',
                            'images' => [
                                'https://nillens.com/cdn/shop/products/IMG_03596_2048x.jpg?v=1680930352',
                            ],

                        ],
                        'unit_amount' => 20 * 100,
                    ],
                    'quantity' => 12,
                ],
                [

                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'HOOdy',
                            'description' => 'this is a cool hoodie',
                            'images' => ['https://nillens.com/cdn/shop/files/IMG_05560_2048x.jpg?v=1729237011'],

                        ],
                        'unit_amount' => 50 * 100,
                    ],
                    'quantity' => 21,
                ],
            ],
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:8000/cancel',
        ]);

        // Redirect the user to the hosted Checkout page
        // Use 303 See Other to ensure GET on redirect
        return redirect($session->url, 303);
    }
}
