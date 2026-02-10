<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('client_name');
            $blueprint->string('client_role')->nullable();
            $blueprint->string('client_image')->nullable();
            $blueprint->text('testimonial_text');
            $blueprint->unsignedTinyInteger('rating')->default(5);
            $blueprint->boolean('is_active')->default(true);
            $blueprint->integer('sort_order')->default(0);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
