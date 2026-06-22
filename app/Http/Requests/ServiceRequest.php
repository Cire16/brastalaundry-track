<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:100',
            'price_per_kg' => 'required|numeric|min:0',
            'description'  => 'nullable|string|max:255',
            'is_active'    => 'boolean',
            'sort_order'   => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Nama layanan wajib diisi.',
            'price_per_kg.required' => 'Harga per kg wajib diisi.',
            'price_per_kg.numeric'  => 'Harga harus berupa angka.',
            'price_per_kg.min'      => 'Harga tidak boleh negatif.',
        ];
    }
}
