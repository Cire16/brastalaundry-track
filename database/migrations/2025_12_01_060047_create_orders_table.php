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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); //ID auto increment
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke user
            $table->string('customer_name'); //Nama customer
            $table->string('phone'); //Nomor telepom
            $table->text('items'); // Jenis Cucian
            $table->decimal('weight', 5, 2); //Berat (max 999.99 kg)
            $table->string('service'); //jenis layanan
            $table->decimal('price', 10, 2); // Harga per Kg
            $table->decimal('total', 10, 2); // Total harga
            $table->enum('status', ['pending', 'in_process', 'ready', 'completed'])->default('pending');
            $table->timestamp('estimated_pickup')->nullable();
            $table->timestamps(); // Created_at & update_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
