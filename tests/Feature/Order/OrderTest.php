<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $order;
    protected  $user;
    protected $payment;

    public function setUp(): void
    {
        parent::setUp();

        $this->user     = User::factory()->create();
        Product::factory(3)->create();

        $this->payment  = Payment::create([
            'payment_type'  => 'credit_card',
            'price'         => 300
        ]);

        $this->order =  Order::create([
            'user_id'       => $this->user->id,
            'products'      => Product::inRandomOrder()->take(rand(1, 2))->pluck('id')->toArray(),
            'price'         => 400,
            'payment_id'    => $this->payment->id,
        ]);
    }

    public function test_api_returns_order_details(): void
    {
        $response = $this->getJson('/api/orders/' . $this->order->id);

        $response->assertStatus(200);
        // $response->assertJson([$order->toArray()]);
    }

    public function test_api_returns_user_orders_details()
    {
        $response = $this->getJson('api/orders?user_id=' . $this->user->id);

        $response->assertStatus(200);
        // $response->assertJson($order->toArray());
    }

    public function test_api_order_store_successful()
    {
        $products   = Product::factory(2)->create();
        $order      = [
            'user_id'       => $this->user->id,
            'price'         => 30,
            'products'      => $products->pluck('id')->toArray(),
            'payment_id'    => $this->payment->id,
        ];
        $response   = $this->postJson('/api/orders', $order);
        $response->assertStatus(201);
        // $response->assertJson([$order->toArray()]);
    }

    public function test_api_order_invalid_store_returns_error()
    {
        $order      = [
            'user_id'       => '',
            'price'         => '',
            'products'      => '',
            'payment_id'    => '',
        ];
        $response   = $this->postJson('/api/orders', $order);
        $response->assertStatus(401);
    }

    public function test_api_order_update_successful()
    {
        $products   = Product::factory(2)->create();
        $order      = [
            'products'      => $products->pluck('id')->toArray(),
        ];
        $response   = $this->putJson('/api/orders', $order);
        $response->assertStatus(405);
        // $response->assertJson([$order->toArray()]);
    }
}
