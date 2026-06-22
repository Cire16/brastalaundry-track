@extends('layouts.user')

@section('title', 'Order History')
@section('page-title', 'Order History')

@section('content')
<div class="section">
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Items</th>
                <th>Weight</th>
                <th>Service</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><strong>INV-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</strong></td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>{{ Str::limit($order->items, 30) }}</td>
                <td>{{ $order->weight ?? '—' }} kg</td>
                <td>{{ $order->service }}</td>
                <td><strong>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</strong></td>
                <td>
                    <span class="badge {{ $order->status }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('user.orders.show', $order) }}"
                       class="btn btn-sm btn-primary">
                        View Details
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 60px; color: #999;">
                    <div style="font-size: 48px; margin-bottom: 10px;">📦</div>
                    <p style="font-size: 18px; margin-bottom: 10px;">No orders yet</p>
                    <a href="{{ route('user.orders.create') }}" class="btn btn-primary">
                        Create Your First Order
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($orders->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
