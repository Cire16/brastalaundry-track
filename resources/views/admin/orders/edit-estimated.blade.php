@extends('layouts.admin')

@section('title', 'Edit Estimasi Pickup')
@section('page-title', 'Edit Estimasi Pickup')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.orders.index') }}"
           style="color: #3d2e2e; text-decoration: none; font-weight: 600;">
            ← Kembali ke Orders
        </a>
    </div>

    {{-- Info order --}}
    <div class="stat-card light" style="margin-bottom: 20px;">
        <h3 style="font-size: 14px; margin-bottom: 10px;">INFO ORDER #{{ $order->id }}</h3>
        <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
        <p><strong>Items:</strong> {{ $order->items }}</p>
        <p><strong>Layanan:</strong> {{ $order->service }}</p>
        <p><strong>Estimasi Saat Ini:</strong>
            {{ $order->estimated_pickup?->format('d/m/Y H:i') ?? '-' }}
        </p>
        @if($order->pickup_note)
            <p><strong>Catatan Sebelumnya:</strong> {{ $order->pickup_note }}</p>
        @endif
    </div>

    {{-- Form --}}
    <div class="section">
        <h3 style="font-size: 16px; margin-bottom: 20px;">UBAH ESTIMASI PICKUP</h3>

        <form action="{{ route('admin.orders.update-estimated', $order) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="estimated_pickup">Estimasi Baru *</label>
                <input type="datetime-local"
                       id="estimated_pickup"
                       name="estimated_pickup"
                       class="form-control"
                       value="{{ old('estimated_pickup', $order->estimated_pickup?->format('Y-m-d\TH:i')) }}"
                       required>
                @error('estimated_pickup')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pickup_note">Alasan Perubahan</label>
                <textarea id="pickup_note"
                          name="pickup_note"
                          class="form-control"
                          rows="3"
                          placeholder="Contoh: Mesin sedang penuh, estimasi mundur 1 hari. / Proses lebih cepat, bisa diambil lebih awal.">{{ old('pickup_note', $order->pickup_note) }}</textarea>
                <span class="form-hint">Alasan ini akan ditampilkan ke customer di halaman detail order mereka.</span>
                @error('pickup_note')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update Estimasi</button>
            </div>
        </form>
    </div>
</div>
@endsection
