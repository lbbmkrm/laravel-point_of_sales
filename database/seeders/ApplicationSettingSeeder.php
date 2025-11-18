<?php

namespace Database\Seeders;

use App\Models\ApplicationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApplicationSetting::create([
            'id' => 1,
            'shop_name' => 'QIA Rongku Coffee',
            'shop_address' => 'Jl. Gatot Subroto No. 123, Medan Petisah, Medan, Sumatera Utara 20112',
            'shop_phone' => '0812-3456-7890',
            'shop_email' => 'hello@qiarongkucoffee.com',
            'shop_instagram' => '@qiarongkucoffee',
            'shop_facebook' => 'QIA Rongku Coffee Official',
            'shop_website' => 'https://www.qiarongkucoffee.com',
            'currency' => 'IDR',
            'currency_symbol' => 'Rp',
            'tax_enabled' => true,
            'tax_rate' => 0.10, // 10%
            'tax_label' => 'PPN',
            'service_charge_enabled' => false,
            'service_charge_rate' => 0.05, // 5%
            'landing_description' => 'Kedai kopi modern dengan suasana nyaman dan berbagai pilihan kopi terbaik di Medan. Kami menyajikan kopi berkualitas tinggi dengan cita rasa yang khas untuk memulai hari Anda dengan sempurna.',
            'operating_hours' => '07:00 - 22:00',
            'operating_days' => 'Senin - Minggu',
            'google_maps_url' => 'https://maps.google.com/?q=QIA+Rongku+Coffee+Medan',
            'timezone' => 'Asia/Jakarta',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
        ]);
    }
}
