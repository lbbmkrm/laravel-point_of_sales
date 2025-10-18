<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun owner
        User::factory()->create([
            'name' => 'Admin QIO Coffee',
            'email' => 'admin@qiocoffee.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
        ]);

        // Buat akun kasir
        User::factory()->create([
            'name' => 'Kasir QIO Coffee',
            'email' => 'kasir@qiocoffee.com',
            'password' => bcrypt('password'),
            'role' => 'cashier',
        ]);
    }
}
