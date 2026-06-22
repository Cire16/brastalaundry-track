@extends('layouts.user')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('user.orders.index') }}"
        style="color: #3d2e2e; text-decoration: none; font-weight: 600;">
            ← Back to Order History
        </a>

        {{-- Tombol edit & cancel hanya muncul kalau belum dikonfirmasi --}}
        @if(!$order->is_confirmed)
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('user.orders.edit', $order) }}"
            class="btn btn-warning btn-sm">
                ✏️ Edit Request
            </a>
            <form action="{{ route('user.orders.destroy', $order) }}"
                method="POST"
                onsubmit="return confirm('Yakin mau batalkan pickup request ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    ✕ Batalkan
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Order Status Card -->
    <div class="card dark" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="opacity: 0.8; margin-bottom: 10px;">ORDER STATUS</h3>
                <div style="font-size: 32px; font-weight: bold;">
                    {{ $order->getStatusLabel() }}
                </div>
                @if(!$order->is_confirmed)
                    <div style="margin-top: 10px; font-size: 14px; opacity: 0.8;">
                        ⏳ Menunggu barang diambil & dikonfirmasi admin
                    </div>
                @endif
            </div>
            <div style="font-size: 64px; opacity: 0.5;">
                @if($order->status == 'pending') ⏳
                @elseif($order->status == 'in_process') 🔄
                @elseif($order->status == 'ready') ✅
                @else ✔️
                @endif
            </div>
        </div>
    </div>

    <!-- Pickup Info (Jika belum dikonfirmasi) -->
    @if(!$order->is_confirmed)
    <div class="section" style="margin-bottom: 20px; background: #fff3cd; border-left: 4px solid #ffc107;">
        <h3 style="font-size: 16px; margin-bottom: 15px; color: #856404;">📦 PICKUP REQUEST</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; color: #856404;">
            <div>
                <div style="margin-bottom: 10px;">
                    <strong>Jadwal Pickup:</strong><br>
                    📅 {{ $order->pickup_date->format('d F Y') }}<br>
                    🕐 {{ $order->pickup_date->format('H:i') }}
                </div>
                <div style="margin-bottom: 10px;">
                    <strong>Alamat:</strong><br>
                    {{ $order->address }}
                </div>
            </div>
            <div>
                <div style="margin-bottom: 10px;">
                    <strong>Barang:</strong> {{ $order->items }}
                </div>
                <div style="margin-bottom: 10px;">
                    <strong>Layanan:</strong> {{ $order->service }}
                </div>
                <div style="margin-bottom: 10px;">
                    <strong>Kontak:</strong> {{ $order->phone }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Order Information -->
    <div class="section">
        <h3 style="font-size: 18px; margin-bottom: 20px; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            ORDER INFORMATION
        </h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <div style="margin-bottom: 15px;">
                    <div style="font-size: 12px; color: #666; margin-bottom: 5px;">ORDER ID</div>
                    <div style="font-weight: 600; font-size: 16px;">INV-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</div>
                </div>

                <div style="margin-bottom: 15px;">
                    <div style="font-size: 12px; color: #666; margin-bottom: 5px;">ORDER DATE</div>
                    <div style="font-weight: 600;">{{ $order->created_at->format('l, d F Y') }}</div>
                    <div style="font-size: 14px; color: #999;">{{ $order->created_at->format('h:i A') }}</div>
                </div>

                <div>
                    <div style="font-size: 12px; color: #666; margin-bottom: 5px;">CUSTOMER</div>
                    <div style="font-weight: 600;">{{ $order->customer_name }}</div>
                    <div style="font-size: 14px; color: #999;">{{ $order->phone }}</div>
                </div>
            </div>

            <div>
                <div style="margin-bottom: 15px;">
                    <div style="font-size: 12px; color: #666; margin-bottom: 5px;">ITEMS</div>
                    <div style="font-weight: 600;">{{ $order->items }}</div>
                </div>

                @if($order->is_confirmed)
                <div style="margin-bottom: 15px;">
                    <div style="font-size: 12px; color: #666; margin-bottom: 5px;">WEIGHT</div>
                    <div style="font-weight: 600; font-size: 18px;">{{ $order->weight }} kg</div>
                </div>
                @endif

                <div>
                    <div style="font-size: 12px; color: #666; margin-bottom: 5px;">SERVICE TYPE</div>
                    <div style="font-weight: 600;">{{ $order->service }}</div>
                    @if($order->is_confirmed)
                        <div style="font-size: 14px; color: #999;">Rp {{ number_format($order->price, 0, ',', '.') }}/kg</div>
                    @endif
                </div>
            </div>
        </div>

        @if($order->estimated_pickup && $order->is_confirmed)
        <div style="background:#d4b5a8; padding:15px; border-radius:8px; margin-top:15px">
            <p style="font-size:12px; margin-bottom:5px"><strong>ESTIMASI SELESAI & SIAP DIAMBIL</strong></p>
            <p style="font-size:18px; font-weight:bold; color:#3d2e2e">
                📅 {{ $order->estimated_pickup->format('l, d F Y - H:i') }}
            </p>
            @if($order->pickup_note)
                <p style="margin-top:8px; font-size:13px; color:#555">
                    📝 <em>{{ $order->pickup_note }}</em>
                </p>
            @endif
        </div>
        @endif
    </div>

    <!-- Price Breakdown (Jika sudah dikonfirmasi) -->
    @if($order->is_confirmed)
    <div class="section">
        <h3 style="font-size: 18px; margin-bottom: 20px; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            PRICE BREAKDOWN
        </h3>

        <div style="margin-bottom: 15px; display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
            <span>{{ $order->service }}</span>
            <span>{{ $order->weight }} kg × Rp {{ number_format($order->price, 0, ',', '.') }}</span>
        </div>

        <div style="display: flex; justify-content: space-between; padding: 15px 0; font-size: 20px; font-weight: bold; color: #3d2e2e;">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
    </div>
    @endif

    @if($order->status == 'ready' && $order->is_confirmed)
    <div style="padding: 20px; background: #d4edda; border-radius: 8px; border-left: 4px solid #28a745; text-align: center;">
        <div style="font-size: 24px; margin-bottom: 10px;">🎉</div>
        <strong style="font-size: 18px; color: #155724;">Your laundry is ready for pickup!</strong>
        <p style="margin-top: 10px; color: #155724;">Please bring this order ID: <strong>INV-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</strong></p>
    </div>
    @endif
</div>
@endsection
