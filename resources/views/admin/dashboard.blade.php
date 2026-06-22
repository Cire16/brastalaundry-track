@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card dark">
        <h3>TOTAL ORDERS</h3>
        <div class="value">{{ $totalOrders }}</div>
    </div>
    <div class="stat-card gray">
        <h3>IN PROCESS</h3>
        <div class="value">{{ $inProcess }}</div>
    </div>
    <div class="stat-card light">
        <h3>COMPLETED TODAY</h3>
        <div class="value">{{ $completedToday }}</div>
    </div>
</div>

{{-- Two-column section --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- Order Tracking --}}
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin-bottom: 0;">ORDER TRACKING</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        <span class="badge {{ $order->status }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #999;">No orders yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent Invoices --}}
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin-bottom: 0;">RECENT INVOICES</h3>
            <a href="{{ route('admin.orders.index') }}" style="color: #d4b5a8; text-decoration: none; font-size: 14px;">
                View All
            </a>
        </div>

        @forelse($recentInvoices as $invoice)
        <div style="padding: 12px 0; border-bottom: 1px solid #eee;">
            <div style="display: flex; justify-content: space-between;">
                <span style="font-weight: 600;">
                    INV-{{ str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }} | {{ $invoice->customer_name }}
                </span>
                <span style="font-weight: 600;">
                    Rp {{ number_format($invoice->total, 0, ',', '.') }}
                </span>
            </div>
        </div>
        @empty
        <p style="text-align: center; color: #999;">No invoices yet</p>
        @endforelse
    </div>
</div>

{{-- FAB --}}
<a href="{{ route('admin.orders.create') }}" class="fab" title="Create New Order">+</a>

@endsection
