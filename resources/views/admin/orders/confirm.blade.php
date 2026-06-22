@extends('layouts.admin')

@section('title', 'Konfirmasi Pickup')
@section('page-title', 'Konfirmasi Pickup & Input Berat')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.orders.index') }}" style="color: #3d2e2e; text-decoration: none; font-weight: 600;">
            ← Kembali ke Orders
        </a>
    </div>

    {{-- Pickup request info --}}
    <div class="stat-card light" style="margin-bottom: 20px;">
        <h3 style="font-size: 16px; margin-bottom: 15px; color: #856404;">📦 PICKUP REQUEST</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <p style="margin-bottom: 10px;"><strong>Customer:</strong> {{ $order->customer_name }}</p>
                <p style="margin-bottom: 10px;"><strong>Phone:</strong> {{ $order->phone }}</p>
                <p style="margin-bottom: 10px;"><strong>Request Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p style="margin-bottom: 10px;">
                    <strong>Pickup Schedule:</strong><br>
                    📅 {{ $order->pickup_date->format('d F Y') }}<br>
                    🕐 {{ $order->pickup_date->format('H:i') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Alamat --}}
    <div class="section" style="margin-bottom: 20px;">
        <h3 style="font-size: 16px;">📍 ALAMAT PICKUP</h3>
        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; font-size: 15px;">
            {{ $order->address }}
        </div>
    </div>

    {{-- Items --}}
    <div class="section" style="margin-bottom: 20px;">
        <h3 style="font-size: 16px;">🧺 BARANG YANG DIAMBIL</h3>
        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <p style="margin-bottom: 8px;"><strong>Items:</strong> {{ $order->items }}</p>
            <p><strong>Service Requested:</strong> {{ $order->service }}</p>
        </div>
    </div>

    {{-- Form konfirmasi --}}
    <div class="section">
        <h3 style="border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 25px;">
            ⚖️ KONFIRMASI SETELAH BARANG DIAMBIL
        </h3>

        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">

                {{-- Berat --}}
                <div class="form-group">
                    <label for="weight">Berat Aktual (kg) *</label>
                    <input type="number"
                           id="weight"
                           name="weight"
                           class="form-control"
                           step="0.1"
                           min="0.1"
                           required
                           autofocus>
                    <span class="form-hint">Timbang barang dan input berat yang akurat</span>
                    @error('weight')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Service --}}
                <div class="form-group">
                    <label for="service_id">Jenis Layanan *</label>
                    <select id="service_id" name="service_id" class="form-control" required>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                    data-price="{{ $service->price_per_kg }}"
                                    {{ $order->service === $service->name ? 'selected' : '' }}>
                                {{ $service->name }} — Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg
                            </option>
                        @endforeach
                    </select>
                    <span class="form-hint">Konfirmasi jenis layanan yang diminta customer</span>
                    @error('service_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Estimasi selesai --}}
            <div class="form-group" style="margin-bottom: 25px;">
                <label for="estimated_pickup">📅 Estimasi Selesai & Siap Diambil *</label>
                <input type="datetime-local"
                       id="estimated_pickup"
                       name="estimated_pickup"
                       class="form-control"
                       required
                       min="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}"
                       value="{{ old('estimated_pickup', now()->addDays(2)->format('Y-m-d\TH:i')) }}">
                <span class="form-hint">
                    Tentukan kapan cucian selesai & bisa diambil customer.<br>
                    💡 Express = 1 hari, Regular = 2–3 hari
                </span>
                @error('estimated_pickup')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Total harga (dinamis via JS) --}}
            <div style="background: #d4b5a8; padding: 25px; border-radius: 10px; margin-bottom: 25px; text-align: center;">
                <div style="font-size: 13px; font-weight: 600; color: #333; margin-bottom: 5px;">TOTAL HARGA</div>
                <div id="totalDisplay" style="font-size: 48px; font-weight: 700; color: #3d2e2e;">Rp 0</div>
                <small style="color: #666;">Harga otomatis dihitung: Berat × Harga per kg</small>
            </div>

            {{-- Info box --}}
            <div style="padding: 15px; background: #d1ecf1; border-radius: 8px; border-left: 4px solid #17a2b8; margin-bottom: 25px;">
                <strong>ℹ️ Yang Terjadi Setelah Konfirmasi:</strong>
                <ul style="margin: 10px 0 0 20px; color: #0c5460; line-height: 1.8;">
                    <li>Status order berubah menjadi "Sedang Diproses"</li>
                    <li>Customer bisa lihat estimasi selesai di dashboard mereka</li>
                </ul>
            </div>

            {{-- Buttons --}}
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">✓ Konfirmasi & Hitung Harga</button>
            </div>
        </form>
    </div>
</div>

<script>
    const weightInput  = document.getElementById('weight');
    const serviceSelect = document.getElementById('service_id');
    const totalDisplay = document.getElementById('totalDisplay');

    function calculateTotal() {
        const weight = parseFloat(weightInput.value) || 0;
        const price  = parseFloat(serviceSelect.selectedOptions[0]?.dataset.price) || 0;
        totalDisplay.textContent = 'Rp ' + (weight * price).toLocaleString('id-ID');
    }

    weightInput.addEventListener('input', calculateTotal);
    serviceSelect.addEventListener('change', calculateTotal);
    calculateTotal();
</script>
@endsection
