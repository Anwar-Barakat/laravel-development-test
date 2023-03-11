<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'       => User::inRandomOrder()->first()->id,
            'price'         => fake()->randomFloat(null, 0, 1000),
            'products'      => Product::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray(),
            'payment_id'    => Payment::inRandomOrder()->first()->id
        ];
    }
}
