<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@jedi.com',
            'email_verified_at' => null,
            'password' => Hash::make('pwdpwd'),
        ]);

        $admin->roles()->attach($adminRole->id);
    }
}
