<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Espresso',
            'description' => 'A strong, concentrated coffee made by forcing pressurized water through finely-ground coffee beans.',
            'price' => 15000.00,
            'image' => 'images/espresso.jpg',
        ]);

        Product::create([
            'name' => 'Latte',
            'description' => 'A coffee drink made with espresso and steamed milk, topped with a light layer of foam.',
            'price' => 25000.00,
            'image' => 'images/latte.jpg',
        ]);

        Product::create([
            'name' => 'Cappuccino',
            'description' => 'An espresso-based coffee drink that originated in Italy, and is traditionally prepared with steamed milk foam.',
            'price' => 22000.00,
            'image' => 'images/cappuccino.jpg',
        ]);

        Product::create([
            'name' => 'Americano',
            'description' => 'A type of coffee drink prepared by diluting an espresso with hot water, giving it a similar strength to, but different flavor from, traditionally brewed coffee.',
            'price' => 20000.00,
            'image' => 'images/americano.jpg',
        ]);
    }
}