<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cargo>
 */
class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->paragraph,
            'weight' => fake()->numberBetween(1, 1000),
            'quantity' => fake()->numberBetween(1, 100),
            'order_id' => function () {
                return Order::factory()->create()->id;
            },
            'shipment_id' => null,
        ];
    }
}
