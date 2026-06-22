@extends('layouts.user')

@section('title', 'Request Pickup')
@section('page-title', 'Request Pickup')

@section('content')
<div class="section" style="max-width: 700px; margin: 0 auto;">
    <form action="{{ route('user.orders.store') }}" method="POST">
        @csrf

        <h3 style="font-size: 15px; margin-bottom: 20px; color: #333;">📍 INFORMASI PICKUP</h3>

        <div class="form-group">
            <label for="customer_name">Nama Lengkap *</label>
            <input type="text"
                   id="customer_name"
                   name="customer_name"
                   class="form-control"
                   value="{{ old('customer_name', auth()->user()->name) }}"
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
                   value="{{ old('phone', auth()->user()->phone) }}"
                   placeholder="Contoh: 081234567890"
                   required>
            <span class="form-hint">Nomor yang bisa dihubungi untuk konfirmasi pickup</span>
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
                      placeholder="Jl. Merdeka No. 123, RT 01/RW 02, Kel. Menteng, Jakarta Pusat"
                      required>{{ old('address') }}</textarea>
            <span class="form-hint">Tulis selengkap mungkin agar driver mudah menemukan lokasi</span>
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
                   value="{{ old('items') }}"
                   placeholder="Contoh: Baju, Celana, Selimut, Sepatu"
                   required>
            <span class="form-hint">Sebutkan jenis barang yang akan diambil</span>
            @error('items')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="service">Jenis Layanan *</label>
            <select id="service" name="service" class="form-control" required>
                @foreach($services as $svc)
                    <option value="{{ $svc->name }}" {{ old('service') === $svc->name ? 'selected' : '' }}>
                        {{ $svc->name }} — Rp {{ number_format($svc->price_per_kg, 0, ',', '.') }}/kg
                    </option>
                @endforeach
            </select>
            <span class="form-hint">Harga final dihitung setelah barang ditimbang</span>
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
                   value="{{ old('pickup_date') }}"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   required>
            <span class="form-hint">Pilih waktu yang sesuai untuk kami mengambil cucian Anda</span>
            @error('pickup_date')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="info-box">
            <strong>📌 Informasi Penting:</strong>
            <ul>
                <li>Barang akan diambil sesuai jadwal yang Anda pilih</li>
                <li>Pastikan ada yang bisa dihubungi saat pickup</li>
                <li>Berat dan harga akan dikonfirmasi setelah barang ditimbang</li>
                <li>Anda akan mendapat notifikasi saat barang siap diambil</li>
            </ul>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 10px;">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">
                Batal
            </a>
            <button type="submit" class="btn btn-primary" style="flex: 1;">
                Request Pickup
            </button>
        </div>
    </form>
</div>
@endsection
