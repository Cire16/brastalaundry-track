<?php
// File: database/migrations/xxxx_xx_xx_add_pickup_fields_to_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambah kolom baru untuk pickup request
            $table->text('address')->nullable()->after('phone');
            $table->datetime('pickup_date')->nullable()->after('address');
            $table->boolean('is_confirmed')->default(false)->after('status');
            $table->datetime('confirmed_at')->nullable()->after('is_confirmed');

            // Update kolom existing jadi nullable (karena diisi admin nanti)
            $table->decimal('weight', 5, 2)->nullable()->change();
            $table->decimal('price', 10, 2)->nullable()->change();
            $table->decimal('total', 10, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['address', 'pickup_date', 'is_confirmed', 'confirmed_at']);
        });
    }
};
