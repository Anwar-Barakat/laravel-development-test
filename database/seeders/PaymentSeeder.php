<?php

namespace Database\Seeders;

use App\Models\Payment;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $payments = [
            [
                'payment_type'  => 'credit_card',
                'price'         => $faker->randomFloat(null, 0, 200)
            ],
            [
                'payment_type'  => 'wire_transfer',
                'price'         => $faker->randomFloat(null, 0, 400)
            ],
        ];

        foreach ($payments as $payment) {
            if (is_null(Payment::where(['payment_type' => $payment['payment_type']])->first()))
                Payment::create($payment);
        }
    }
}