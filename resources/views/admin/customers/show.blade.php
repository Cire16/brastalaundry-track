@extends('layouts.admin')

@section('title', 'Customer Details')
@section('page-title', 'Customer Details')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.customers.index') }}" style="color: #3d2e2e; text-decoration: none; font-weight: 600;">
        ← Back to Customers
    </a>
</div>

<!-- Customer Info Card -->
<div class="stat-card dark" style="margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: start;">
        <div>
            <h3 style="font-size: 14px; opacity: 0.8; margin-bottom: 10px;">CUSTOMER INFORMATION</h3>
            <div style="font-size: 28px; font-weight: bold; margin-bottom: 10px;">
                {{ $customer->name }}
            </div>
            <div style="opacity: 0.9; margin-bottom: 5px;">
                📧 {{ $customer->email }}
            </div>
            <div style="opacity: 0.9;">
                📱 {{ $customer->phone ?? 'No phone number' }}
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 48px; font-weight: bold; color: #d4b5a8;">
                {{ $customer->orders->count() }}
            </div>
            <div style="font-size: 14px; opacity: 0.8;">Total Orders</div>
        </div>
    </div>
    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.2); opacity: 0.8;">
        Member since: {{ $customer->created_at->format('d F Y') }}
    </div>
</div>

<!-- Order History -->
<div class="section">
    <h3 style="font-size: 18px; margin-bottom: 20px; color: #333;">ORDER HISTORY</h3>

    @if($orders->count() > 0)
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
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ Str::limit($order->items, 20) }}</td>
                <td>{{ $order->weight }} kg</td>
                <td>{{ $order->service }}</td>
                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td>
                    <span class="badge {{ $order->status }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.print', $order) }}"
                       target="_blank"
                       class="btn btn-sm"
                       style="background: #17a2b8; color: white; padding: 5px 10px; font-size: 12px; text-decoration: none; border-radius: 5px;">
                        Print
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div style="margin-top: 20px;">
        {{ $orders->links() }}
    </div>
    @endif
    @else
    <p style="text-align: center; color: #999; padding: 40px 0;">
        This customer hasn't placed any orders yet.
    </p>
    @endif
</div>

<!-- Quick Actions -->
<div style="text-align: center; margin-top: 30px;">
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
        + Create Order for This Customer
    </a>
</div>
@endsection
