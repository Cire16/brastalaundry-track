@extends('layouts.admin')

@section('title', 'Create New Order')
@section('page-title', 'Create New Order')

@section('content')
<div class="section" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 10px;">

            {{-- Customer dropdown (opsional) --}}
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="user_id">Pilih Customer Terdaftar <span style="color:#999; font-weight:400;">(opsional)</span></label>
                <select id="user_id" name="user_id" class="form-control">
                    <option value="">— Isi manual atau pilih customer —</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-phone="{{ $user->phone }}"
                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <span class="form-hint">Pilih untuk auto-isi nama & HP, atau biarkan kosong dan isi manual.</span>
                @error('user_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Customer name --}}
            <div class="form-group">
                <label for="customer_name">Nama Customer *</label>
                <input type="text" id="customer_name" name="customer_name"
                       class="form-control"
                       value="{{ old('customer_name') }}" required>
                @error('customer_name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="form-group">
                <label for="phone">Nomor HP *</label>
                <input type="text" id="phone" name="phone"
                       class="form-control"
                       value="{{ old('phone') }}" required>
                @error('phone')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Items --}}
            <div class="form-group">
                <label for="items">Jenis Cucian *</label>
                <input type="text" id="items" name="items"
                       class="form-control"
                       value="{{ old('items') }}"
                       placeholder="Contoh: Baju, Celana, Selimut" required>
                @error('items')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Weight --}}
            <div class="form-group">
                <label for="weight">Berat (kg) *</label>
                <input type="number" id="weight" name="weight"
                       class="form-control"
                       value="{{ old('weight') }}"
                       step="0.1" min="0.1" required>
                @error('weight')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Service from DB --}}
            <div class="form-group">
                <label for="service_id">Jenis Layanan *</label>
                <select id="service_id" name="service_id" class="form-control" required>
                    <option value="">— Pilih Layanan —</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}"
                                data-price="{{ $service->price_per_kg }}"
                                {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }} — Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Estimated pickup --}}
            <div class="form-group">
                <label for="estimated_pickup">Estimasi Selesai <span style="color:#999; font-weight:400;">(opsional)</span></label>
                <input type="datetime-local" id="estimated_pickup" name="estimated_pickup"
                       class="form-control"
                       value="{{ old('estimated_pickup') }}">
            </div>
        </div>

        {{-- Total preview --}}
        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
            <div style="font-size: 13px; color: #666; margin-bottom: 5px;">TOTAL HARGA</div>
            <div id="totalDisplay" style="font-size: 36px; font-weight: 700; color: #3d2e2e;">Rp 0</div>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Order</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('user_id').addEventListener('change', function () {
        const opt = this.selectedOptions[0];
        document.getElementById('customer_name').value = opt.dataset.name  ?? '';
        document.getElementById('phone').value          = opt.dataset.phone ?? '';
    });

    const weightInput   = document.getElementById('weight');
    const serviceSelect = document.getElementById('service_id');
    const totalDisplay  = document.getElementById('totalDisplay');

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
