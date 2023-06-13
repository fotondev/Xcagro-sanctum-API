<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);

        User::create([
            'name' => 'Luke Skywalker',
            'email' => 'luke@jedi.com',
            'email_verified_at' => null,
            'password' => Hash::make('pwdpwd'),
        ]);



        Order::factory(5)->create();
    }
}
