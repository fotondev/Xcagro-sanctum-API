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
        $order1 = Order::factory()->create(['status' => 'shipped']);
        $order2 = Order::factory()->create(['status' => 'pending']);

        $response = $this->get('/api/orders?sortBy=status');

        $response->assertJsonPath('data.0.attributes.id', $order1->id);
        $response->assertJsonPath('data.1.attributes.id', $order2->id);
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
            'created_at' => Carbon::now()->subHour()
        ]);
        $order3 = Order::factory()->create([
            'total_price' => 900,
            'created_at' => Carbon::now()
        ]);

        $response = $this->get('/api/orders?priceFrom=8&priceTo=10&dateFrom=' . Carbon::today() . '&dateTo=' . Carbon::tomorrow() . '&sortBy=total_price&sortOrder=asc');
        $response->assertStatus(200);



        // $response->assertJsonPath('data.0.attributes.id', $order2->id);
        // $response->assertJsonPath('data.1.attributes.id', $order1->id);
    }
}
