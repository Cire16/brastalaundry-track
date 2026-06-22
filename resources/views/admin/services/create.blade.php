@extends('layouts.admin')

@section('title', 'Tambah Layanan')
@section('page-title', 'Tambah Layanan Baru')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.services.index') }}" style="color: #3d2e2e; text-decoration: none; font-weight: 600;">
            ← Kembali
        </a>
    </div>

    <div class="section">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Layanan *</label>
                <input type="text"
                       id="name"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Cuci + Setrika"
                       required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price_per_kg">Harga per kg (Rp) *</label>
                <input type="number"
                       id="price_per_kg"
                       name="price_per_kg"
                       class="form-control"
                       value="{{ old('price_per_kg') }}"
                       min="0"
                       step="500"
                       placeholder="Contoh: 7000"
                       required>
                @error('price_per_kg')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi (opsional)</label>
                <input type="text"
                       id="description"
                       name="description"
                       class="form-control"
                       value="{{ old('description') }}"
                       placeholder="Contoh: Cuci dan setrika dalam 2-3 hari">
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sort_order">Urutan Tampil</label>
                <input type="number"
                       id="sort_order"
                       name="sort_order"
                       class="form-control"
                       value="{{ old('sort_order', 0) }}"
                       min="0">
                <span class="form-hint">Angka kecil = tampil lebih atas di dropdown</span>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                           style="width: 18px; height: 18px;">
                    <span>Aktifkan layanan ini</span>
                </label>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>
@endsection
