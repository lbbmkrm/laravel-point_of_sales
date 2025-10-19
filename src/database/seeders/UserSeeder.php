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
        User::created([
            'name' => 'Admin QIO Coffee',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'owner'
        ]);

        User::created([
            'name' => 'Cashier QIO Coffee',
            'username' => 'cashier',
            'password' => bcrypt('password123'),
            'role' => 'cashier'
        ]);
    }
}
