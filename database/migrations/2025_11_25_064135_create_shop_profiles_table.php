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
        Schema::create('shop_profiles', function (Blueprint $table) {
            $table->id();
            // Shop Information
            $table->string('name');
            $table->string('about')->nullable();
            $table->string('logo')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();

            // Landing Page Settings
            $table->text('landing_description')->nullable();
            $table->string('operating_hours')->default('00:00 - 00:00');
            $table->string('operating_days')->default('Day, - Day');
            $table->text('google_maps_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_profiles');
    }
};
