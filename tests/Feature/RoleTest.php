<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_user_cannot_access_adding_users(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/admin/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_adding_users(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $role = Role::create(['name' => 'admin']);
        $user->roles()->attach($role->id);

        $data = [
            'name' => 'Ozzy',
            'email' => 'ozzy@mail.com',
            'password' => 'pwdpwdpwd',
            'password_confirmation' =>'pwdpwdpwd'
        ];
        $repsonse = $this->postJson('/api/admin/users', $data);

        $repsonse->assertStatus(201);
    }
}
