<?php

namespace Database\Factories;

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
            'order_number' => $this->faker->unique()->randomNumber(),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped']),
            'total_price' => $this->faker->numberBetween(1000, 10000),
            'customer_id' => function () {
                return \App\Models\Customer::factory()->create()->id;
            },
            'shipment_id' => null,
        ];
    }
}
