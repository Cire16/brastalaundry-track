<?php

namespace Database\Seeders;

use App\Models\LaundryService;
use Illuminate\Database\Seeder;

class LaundryServiceSeeder extends Seeder
{
    /**
     * Seed layanan default (migrasi data dari hardcoded array lama)
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Cuci + Setrika', 'price_per_kg' => 7000,  'sort_order' => 1],
            ['name' => 'Cuci Saja',       'price_per_kg' => 5000,  'sort_order' => 2],
            ['name' => 'Setrika Saja',    'price_per_kg' => 4000,  'sort_order' => 3],
            ['name' => 'Express (1 Hari)','price_per_kg' => 12000, 'sort_order' => 4],
        ];

        foreach ($services as $service) {
            LaundryService::firstOrCreate(
                ['name' => $service['name']],
                array_merge($service, ['is_active' => true])
            );
        }
    }
}
