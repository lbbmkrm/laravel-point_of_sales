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
        Schema::create('application_settings', function (Blueprint $table) {
            $table->id();
            // Cashier Settings
            $table->string('currency', 10)->default('IDR');
            $table->string('currency_symbol', 10)->default('Rp');
            $table->boolean('tax_enabled')->default(false);
            $table->decimal('tax_rate', 5, 4)->default(0);
            $table->string('tax_label', 50)->default('PPN');
            $table->boolean('service_charge_enabled')->default(false);
            $table->decimal('service_charge_rate', 5, 4)->default(0);

            // System Settings
            $table->string('timezone')->default('Asia/Jakarta');
            $table->string('date_format')->default('d/m/Y');
            $table->string('time_format')->default('H:i');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_settings');
    }
};
