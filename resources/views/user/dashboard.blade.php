@extends('layouts.user')

@section('title', 'My Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Notifikasi perubahan estimasi --}}
@if($currentOrder && $currentOrder->pickup_note)
<div style="background: #fff3cd; border-left: 4px solid #ffc107;
            padding: 16px 20px; border-radius: 8px; margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <p style="font-weight: 700; color: #856404; margin-bottom: 6px;">
                📢 Update Estimasi Order #{{ $currentOrder->id }}
            </p>
            <p style="color: #856404; font-size: 14px; margin-bottom: 6px;">
                📝 <em>{{ $currentOrder->pickup_note }}</em>
            </p>
            <p style="color: #856404; font-size: 14px;">
                📅 Estimasi baru:
                <strong>{{ $currentOrder->estimated_pickup->format('d F Y, H:i') }}</strong>
            </p>
        </div>
        <a href="{{ route('user.orders.show', $currentOrder) }}"
           style="font-size: 13px; color: #856404; text-decoration: underline; white-space: nowrap; margin-left: 15px;">
            Lihat Detail
        </a>
    </div>
</div>
@endif

{{-- Current order status --}}
<div class="card-grid">
    @if($currentOrder)
        <div class="card dark">
            <h3>Current Order Status</h3>
            <div class="title">{{ $currentOrder->getStatusLabel() }}</div>
            <div class="subtitle">Order ID: INV-{{ str_pad($currentOrder->id, 3, '0', STR_PAD_LEFT) }}</div>

            @if($currentOrder->is_confirmed)
                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.2);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="opacity: 0.8;">Berat:</span>
                        <span style="font-weight: 600;">{{ $currentOrder->weight }} kg</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="opacity: 0.8;">Total:</span>
                        <span style="font-weight: 600;">Rp {{ number_format($currentOrder->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            @else
                <div style="margin-top: 15px; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 5px; font-size: 13px;">
                    ⏳ Menunggu pickup & konfirmasi dari admin
                </div>
            @endif
        </div>

        <div class="card light">
            <h3>
                {{ $currentOrder->is_confirmed ? 'Est. Selesai' : 'Jadwal Pickup' }}
            </h3>
            @php
                $scheduleDate = $currentOrder->is_confirmed && $currentOrder->estimated_pickup
                    ? $currentOrder->estimated_pickup
                    : $currentOrder->pickup_date;
            @endphp
            @if($scheduleDate)
                <div class="title">{{ $scheduleDate->format('l') }}</div>
                <div class="subtitle">{{ $scheduleDate->format('d M Y, H:i') }}</div>
            @else
                <div class="title">TBA</div>
                <div class="subtitle">To Be Announced</div>
            @endif
        </div>

    @else
        <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
            <h3>No Active Order</h3>
            <p style="margin: 16px 0; color: #999;">Kamu belum punya order aktif saat ini.</p>
            <a href="{{ route('user.orders.create') }}" class="btn btn-primary">Request Pickup</a>
        </div>
    @endif
</div>

{{-- Pending pickup info --}}
@if($currentOrder && !$currentOrder->is_confirmed)
<div class="section" style="background: #fff3cd; border-left: 4px solid #ffc107; margin-bottom: 20px;">
    <h3 style="font-size: 15px; color: #856404;">📦 DETAIL PICKUP REQUEST</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; color: #856404; margin-bottom: 12px;">
        <div>
            <p style="margin-bottom: 8px;"><strong>Alamat Pickup:</strong><br>{{ $currentOrder->address }}</p>
            <p><strong>Barang:</strong> {{ $currentOrder->items }}</p>
        </div>
        <div>
            <p style="margin-bottom: 8px;"><strong>Layanan:</strong> {{ $currentOrder->service }}</p>
            <p><strong>Kontak:</strong> {{ $currentOrder->phone }}</p>
        </div>
    </div>
    <div style="margin-top: 15px; padding: 10px; background: rgba(255,255,255,0.5); border-radius: 5px; font-size: 14px; color: #856404;">
        💡 Admin akan menghubungi Anda untuk konfirmasi pickup. Berat & harga akan diinformasikan setelah barang ditimbang.
    </div>

    {{-- Tombol Edit & Batalkan --}}
    <div style="margin-top: 15px; display: flex; gap: 10px;">
        <a href="{{ route('user.orders.edit', $currentOrder) }}"
        class="btn btn-sm btn-warning">
            ✏️ Edit Request
        </a>
        <form action="{{ route('user.orders.destroy', $currentOrder) }}"
            method="POST"
            onsubmit="return confirm('Yakin mau batalkan pickup request ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                ✕ Batalkan
            </button>
        </form>
    </div>
</div>
@endif

{{-- Order history --}}
<div class="section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin-bottom: 0;">Order History</h3>
        <a href="{{ route('user.orders.index') }}" style="color: #d4b5a8; text-decoration: none; font-size: 14px;">
            View All History
        </a>
    </div>

    @if($orderHistory->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Weight</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderHistory as $order)
            <tr>
                <td>INV-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="badge {{ $order->status }}">
                        {{ $order->getStatusLabel() }}
                    </span>
                </td>
                <td>{{ $order->weight ?? '—' }} kg</td>
                <td>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p style="text-align: center; color: #999; padding: 40px 0;">No completed orders yet</p>
    @endif
</div>

{{-- FAB --}}
<a href="{{ route('user.orders.create') }}" class="fab" title="Request Pickup">+</a>

@endsection
