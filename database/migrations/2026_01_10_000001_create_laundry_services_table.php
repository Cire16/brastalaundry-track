<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundry_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');                         // Nama layanan, e.g. "Cuci + Setrika"
            $table->decimal('price_per_kg', 10, 2);        // Harga per kg
            $table->text('description')->nullable();        // Deskripsi opsional
            $table->boolean('is_active')->default(true);    // Bisa di-nonaktifkan tanpa hapus
            $table->unsignedInteger('sort_order')->default(0); // Urutan tampil di dropdown
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundry_services');
    }
};
