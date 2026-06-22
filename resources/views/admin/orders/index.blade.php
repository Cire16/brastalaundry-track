@extends('layouts.admin')

@section('title', 'All Orders')
@section('page-title', 'Orders Management')

@section('content')
<div style="margin-bottom: 20px; text-align: right;">
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">+ Create New Order</a>
</div>

<div class="section">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Phone / Address</th>
                    <th>Pickup Schedule</th>
                    <th>Items</th>
                    <th>Service</th>
                    <th>Weight / Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr {{ !$order->is_confirmed ? 'style=background:#fff3cd' : '' }}>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td><strong>{{ $order->customer_name }}</strong></td>
                    <td>
                        <div style="font-size: 13px;">
                            📱 {{ $order->phone }}<br>
                            @if($order->address)
                                📍 {{ Str::limit($order->address, 30) }}
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($order->is_confirmed && $order->estimated_pickup)
                            <div style="font-size: 13px;">
                                📅 {{ $order->estimated_pickup->format('d/m/Y') }}<br>
                                🕐 {{ $order->estimated_pickup->format('H:i') }}
                            </div>
                        @elseif($order->pickup_date)
                            <div style="font-size: 13px; color: #999;">
                                📅 {{ $order->pickup_date->format('d/m/Y') }}<br>
                                🕐 {{ $order->pickup_date->format('H:i') }}
                                <br><small><em>Belum dikonfirmasi</em></small>
                            </div>
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ Str::limit($order->items, 30) }}</td>
                    <td>{{ $order->service }}</td>
                    <td>
                        @if($order->is_confirmed)
                            <div style="font-size: 13px;">
                                ⚖️ {{ $order->weight }} kg<br>
                                💰 Rp {{ number_format($order->total, 0, ',', '.') }}
                            </div>
                        @else
                            <span style="color: #999; font-style: italic;">Belum ditimbang</span>
                        @endif
                    </td>
                    <td>
                        @if(!$order->is_confirmed)
                            <span class="badge" style="background: #ff9800; color: white;">⏳ Menunggu Pickup</span>
                        @else
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status"
                                        class="badge {{ $order->status }}"
                                        onchange="this.form.submit()"
                                        style="padding: 5px; border-radius: 5px; border: 1px solid #ddd;">
                                    <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                                    <option value="in_process" {{ $order->status === 'in_process' ? 'selected' : '' }}>In Process</option>
                                    <option value="ready"      {{ $order->status === 'ready'      ? 'selected' : '' }}>Ready</option>
                                    <option value="completed"  {{ $order->status === 'completed'  ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        @endif
                    </td>
                    <td style="white-space: nowrap;">
                        @if(!$order->is_confirmed)
                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-success">
                                ✓ Konfirmasi Pickup
                            </a>
                        @else
                            @if($order->status === 'in_process')
                                <a href="{{ route('admin.orders.edit-estimated', $order) }}"
                                class="btn btn-sm btn-warning">
                                    Edit Estimasi
                                </a>
                            @endif
                            <a href="{{ route('admin.orders.print', $order) }}"
                            target="_blank"
                            class="btn btn-sm btn-info">
                                Print
                            </a>
                        @endif

                        <form action="{{ route('admin.orders.destroy', $order) }}"
                              method="POST"
                              style="display: inline;"
                              onsubmit="return confirm('Hapus order ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 40px; color: #999;">
                        No orders found. <a href="{{ route('admin.orders.create') }}">Create your first order</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div style="margin-top: 20px;">{{ $orders->links() }}</div>
    @endif
</div>

<div style="margin-top: 10px; padding: 15px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
    <strong>💡 Tips:</strong> Order dengan highlight kuning adalah pickup request yang belum dikonfirmasi.
    Klik "Konfirmasi Pickup" untuk input berat & hitung harga.
</div>
@endsection
