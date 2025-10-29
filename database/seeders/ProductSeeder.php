<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kopiCategory = Category::where('name', 'Kopi')->firstOrFail();
        $nonKopiCategory = Category::where('name', 'Non Kopi')->firstOrFail();
        $makananCategory = Category::where('name', 'Makanan')->firstOrFail();

        Product::create([
            'name' => 'Espresso',
            'description' => 'Kopi hitam pekat.',
            'price' => 15000.00,
            'image' => 'images/espresso.jpg',
            'category_id' => $kopiCategory->id,
        ]);

        Product::create([
            'name' => 'Latte',
            'description' => 'Kopi dengan susu kukus dan sedikit busa.',
            'price' => 25000.00,
            'image' => 'images/latte.jpg',
            'category_id' => $kopiCategory->id,
        ]);

        Product::create([
            'name' => 'Cappuccino',
            'description' => 'Minuman kopi berbasis espresso dengan susu kukus dan busa tebal.',
            'price' => 22000.00,
            'image' => 'images/cappuccino.jpg',
            'category_id' => $kopiCategory->id,
        ]);

        Product::create([
            'name' => 'Americano',
            'description' => 'Espresso yang diencerkan dengan air panas.',
            'price' => 20000.00,
            'image' => 'images/americano.jpg',
            'category_id' => $kopiCategory->id,
        ]);

        Product::create([
            'name' => 'Matcha Latte',
            'description' => 'Minuman teh hijau matcha dengan susu.',
            'price' => 28000.00,
            'image' => 'images/matcha_latte.jpg',
            'category_id' => $nonKopiCategory->id,
        ]);

        Product::create([
            'name' => 'Croissant',
            'description' => 'Roti pastry renyah.',
            'price' => 18000.00,
            'image' => 'images/croissant.jpg',
            'category_id' => $makananCategory->id,
        ]);
    }
}