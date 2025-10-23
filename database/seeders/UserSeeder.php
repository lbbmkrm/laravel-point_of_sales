<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin QIO Coffee',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'phone' => '08123456789',
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Cashier QIO Coffee',
            'username' => 'cashier',
            'password' => bcrypt('password123'),
            'phone' => '08123456789',
            'role' => 'cashier',
        ]);
    }
}
