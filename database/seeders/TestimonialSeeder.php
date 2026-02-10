<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Riska Pratiwi',
                'client_role' => 'Content Creator',
                'client_image' => 'https://i.pravatar.cc/150?img=5',
                'testimonial_text' => 'Qio Coffee adalah tempat favorit saya untuk bekerja! Kopinya enak, WiFi cepat, dan suasananya sangat nyaman. Cappuccino mereka adalah yang terbaik yang pernah saya coba di Medan.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Andi Wijaya',
                'client_role' => 'Entrepreneur',
                'client_image' => 'https://i.pravatar.cc/150?img=12',
                'testimonial_text' => 'Sebagai penikmat kopi, saya sangat puas dengan kualitas biji kopi yang digunakan. Pour Over mereka benar-benar memunculkan karakter kopi yang kompleks. Highly recommended!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Sarah Melinda',
                'client_role' => 'Marketing Manager',
                'client_image' => 'https://i.pravatar.cc/150?img=9',
                'testimonial_text' => 'Tempat yang sempurna untuk meeting dengan klien atau sekadar me-time. Pelayanan ramah, menu beragam, dan harga sangat reasonable. Cheesecake-nya juga juara!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'Budi Santoso',
                'client_role' => 'Software Developer',
                'client_image' => 'https://i.pravatar.cc/150?img=14',
                'testimonial_text' => 'Sudah langganan di sini hampir setahun. Iced Americano mereka selalu konsisten rasanya. Barista-nya juga friendly dan profesional. Sukses terus Qio Coffee!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'client_name' => 'Dian Kusuma',
                'client_role' => 'Graphic Designer',
                'client_image' => 'https://i.pravatar.cc/150?img=20',
                'testimonial_text' => 'Ambiance-nya cozy banget! Instagram-able dan cocok buat foto-foto. Yang paling saya suka adalah Matcha Latte mereka yang creamy dan tidak terlalu manis. Perfect!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
