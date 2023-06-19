<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Order;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CargoTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
    }


    /** @test */
    public function test_auth_user_can_list_cargos_by_order()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $order = Order::factory()->create();
        $cargos = Cargo::factory(3)->create([
            'order_id' => $order->id,
        ]);


        $response = $this->getJson('/api/orders/' . $order->id . '/cargos');

        $response->assertStatus(200);


        $response->assertJsonCount(3);


        foreach ($cargos as $cargo) {
            $response->assertJsonFragment([
                'id' => $cargo->id,
                'name' => $cargo->name,
                'description' => $cargo->description,
                'weight' => $cargo->weight,
                'quantity' => $cargo->quantity,
                'order_id' => $order->id,
            ]);
        }
    }

    /** @test */
    public function test_auth_user_can_add_cargo_to_order()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $order = Order::factory()->create();

        $response = $this->post('/api/orders/' . $order->id . '/cargos', [
            'name' => 'Test Cargo',
            'description' => 'This is a test cargo.',
            'weight' => 500,
            'quantity' => 2,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('cargos', [
            'name' => 'Test Cargo',
            'description' => 'This is a test cargo.',
            'weight' => 500,
            'quantity' => 2,
            'order_id' => $order->id,
        ]);
    }

    /** @test */
    public function test_returns_404_error_for_non_existent_order()
    {
        $response = $this->post('/api/orders/' . 'non-existent-order-id' . '/cargos', [
            'name' => 'Test Cargo',
            'description' => 'This is a test cargo.',
            'weight' => 500,
            'quantity' => 2,
        ]);

        $response->assertStatus(404);
    }
}
