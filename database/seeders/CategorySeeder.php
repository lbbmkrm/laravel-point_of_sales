<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::firstOrCreate(['name' => 'Kopi', 'description' => 'Minuman berbasis kopi']);
        Category::firstOrCreate(['name' => 'Non Kopi', 'description' => 'Minuman non-kopi']);
        Category::firstOrCreate(['name' => 'Makanan', 'description' => 'Aneka makanan ringan dan berat']);
    }
}
