<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_per_kg',
        'description',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_per_kg' => 'decimal:2',
            'is_active'    => 'boolean',
            'sort_order'   => 'integer',
        ];
    }

    /**
     * Scope: hanya service yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Format harga ke rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_kg, 0, ',', '.');
    }
}
