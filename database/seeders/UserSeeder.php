<?php
// File: database/seeders/UserSeeder.php
// Fungsi: Bikin data dummy user (admin & customer)

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bikin user admin
        User::create([
            'name' => 'Admin Laundry',
            'email' => 'admin@laundry.com',
            'phone' => '081234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Bikin user customer
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567891',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Bikin customer kedua
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '081234567892',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}
