@extends('layouts.user')

@section('title', 'Edit Pickup Request')
@section('page-title', 'Edit Pickup Request')

@section('content')
<div class="section" style="max-width: 700px; margin: 0 auto;">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('user.orders.show', $order) }}"
           style="color: #3d2e2e; text-decoration: none; font-weight: 600;">
            ← Kembali
        </a>
    </div>

    <div style="margin-bottom: 20px; padding: 15px; background: #fff3cd;
                border-left: 4px solid #ffc107; border-radius: 8px;">
        <strong style="color: #856404;">⚠️ Catatan:</strong>
        <span style="color: #856404;">
            Order hanya bisa diedit selama belum dikonfirmasi oleh admin.
        </span>
    </div>

    <form action="{{ route('user.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        <h3 style="font-size: 15px; margin-bottom: 20px; color: #333;">📍 INFORMASI PICKUP</h3>

        <div class="form-group">
            <label for="customer_name">Nama Lengkap *</label>
            <input type="text"
                   id="customer_name"
                   name="customer_name"
                   class="form-control"
                   value="{{ old('customer_name', $order->customer_name) }}"
                   required>
            @error('customer_name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Nomor HP / WhatsApp *</label>
            <input type="text"
                   id="phone"
                   name="phone"
                   class="form-control"
                   value="{{ old('phone', $order->phone) }}"
                   required>
            @error('phone')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Alamat Lengkap *</label>
            <textarea id="address"
                      name="address"
                      class="form-control"
                      rows="3"
                      required>{{ old('address', $order->address) }}</textarea>
            @error('address')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <hr style="border: none; border-top: 1px solid #eee; margin: 24px 0;">
        <h3 style="font-size: 15px; margin-bottom: 20px; color: #333;">🧺 DETAIL CUCIAN</h3>

        <div class="form-group">
            <label for="items">Jenis Barang *</label>
            <input type="text"
                   id="items"
                   name="items"
                   class="form-control"
                   value="{{ old('items', $order->items) }}"
                   required>
            @error('items')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="service">Jenis Layanan *</label>
            <select id="service" name="service" class="form-control" required>
                @foreach($services as $svc)
                    <option value="{{ $svc->name }}"
                        {{ old('service', $order->service) === $svc->name ? 'selected' : '' }}>
                        {{ $svc->name }} — Rp {{ number_format($svc->price_per_kg, 0, ',', '.') }}/kg
                    </option>
                @endforeach
            </select>
            @error('service')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <hr style="border: none; border-top: 1px solid #eee; margin: 24px 0;">
        <h3 style="font-size: 15px; margin-bottom: 20px; color: #333;">📅 JADWAL PICKUP</h3>

        <div class="form-group">
            <label for="pickup_date">Tanggal & Jam Pickup *</label>
            <input type="datetime-local"
                   id="pickup_date"
                   name="pickup_date"
                   class="form-control"
                   value="{{ old('pickup_date', $order->pickup_date->format('Y-m-d\TH:i')) }}"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   required>
            @error('pickup_date')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 10px; margin-top: 10px;">
            <a href="{{ route('user.orders.show', $order) }}"
               class="btn btn-secondary" style="flex: 1; text-align: center;">
                Batal
            </a>
            <button type="submit" class="btn btn-primary" style="flex: 1;">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
