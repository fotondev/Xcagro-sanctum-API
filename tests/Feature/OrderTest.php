<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use Carbon\Carbon;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_orders_list_sorts_by_status()
    {

        $pendingOrder = Order::factory()->create(['status' => 'pending']);
        $completedOrder = Order::factory()->create(['status' => 'shipped']);


        $response = $this->get('/api/orders?sortBy=status');

        $response->assertStatus(200);
        $response->assertSeeInOrder([$completedOrder->id, $pendingOrder->id]);
    }


    /** @test */
    public function test_orders_list_sorts_by_date()
    {
        $order1 = Order::factory()->create([
            'total_price' => 400,
            'created_at' => Carbon::now()
        ]);
        $order2 = Order::factory()->create([
            'total_price' => 500,
            'created_at' => Carbon::now()->subDay()
        ]);
        $order3 = Order::factory()->create([
            'total_price' => 900,
            'created_at' => Carbon::now()
        ]);

        $response = $this->get('/api/orders?dateFrom=' . Carbon::today() . '&dateTo=' . Carbon::tomorrow());
        
        $response->assertStatus(200);

        // $response->assertSeeInOrder([$order3->id, $order1->id, $order2->id]);

        // $response->assertJsonPath('data.0.attributes.id', $order2->id);
        // $response->assertJsonPath('data.1.attributes.id', $order1->id);
    }
}
