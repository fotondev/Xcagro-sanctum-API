<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
    }


    /** @test */
    public function authenticated_user_can_list_customers(): void
    {

        Sanctum::actingAs(
            User::first(),
        );

        Customer::factory(16)->create();

        $response = $this->get('/api/customers');

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page', 2);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'attributes' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'created_at',
                        'updated_at',
                    ],
                    'relationships' => [
                        'orders',
                    ],
                    'links' => [
                        'self',
                    ],
                ]
            ],
            'links',
            'meta',
        ]);
    }


    // /** @test */
    // public function it_returns_a_single_customer()
    // {
    //     $customer = Customer::factory()->create();

    //     $response = $this->getJson("/api/customers/{$customer->id}");

    //     $response->assertStatus(200);
    //     $response->assertJson([
    //         'customers' => [
    //             'attributes' => [
    //                 'id' => $customer->id,
    //                 'name' => $customer->name,
    //                 'email' => $customer->email,
    //                 'phone' => $customer->phone,
    //                 'created_at' => $customer->created_at->toISOString(),
    //                 'updated_at' => $customer->updated_at->toISOString(),
    //             ],
    //             'relationships' => [
    //                 'orders',
    //             ],
    //             'links' => [
    //                 'self' => route('customer.show', $customer->id),
    //             ],
    //         ],
    //         'status' => 'succes'
    //     ]);
    // }

    /** @test */
    public function authenticated_user_can_create_a_customer()
    {

        Sanctum::actingAs(
            User::first(),
        );

        $customerData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '123-456-7890'
        ];

        $response = $this->postJson('/api/customers', $customerData);

        $response->assertStatus(201);
        $response->assertJson([
            'customers' => [
                'attributes' => [
                    'name' => $customerData['name'],
                    'email' => $customerData['email'],
                    'phone' => $customerData['phone'],
                ]
            ]
        ]);
        $this->assertDatabaseHas('customers', [
            'name' => $customerData['name'],
            'email' => $customerData['email'],
            'phone' => $customerData['phone'],
        ]);
    }

    /** @test */
    public function authenticated_user_can_update_a_customer()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $customer = Customer::factory()->create();

        $customerData = [
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com',
            'phone' => '555-555-5555'
        ];

        $response = $this->putJson("/api/customers/{$customer->id}", $customerData);

        $response->assertStatus(201);
        $response->assertJson([
            'customers' => [
                'attributes' => [
                    'id' => $customer->id,
                    'name' => $customerData['name'],
                    'email' => $customerData['email'],
                    'phone' => $customerData['phone'],
                ]
            ]
        ]);
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => $customerData['name'],
            'email' => $customerData['email'],
            'phone' => $customerData['phone'],
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_a_customer()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }
}
