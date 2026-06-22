@extends('layouts.admin')

@section('title', 'Invoices')
@section('page-title', 'Invoices Management')

@section('content')
<!-- Revenue Stats -->
<div class="stats-grid" style="margin-bottom: 30px;">
    <div class="stat-card" style="background: #28a745; color: white;">
        <h3>TOTAL REVENUE (COMPLETED)</h3>
        <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card" style="background: #ffc107; color: #333;">
        <h3>PENDING REVENUE</h3>
        <div class="value">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Filters -->
<div class="section" style="margin-bottom: 20px;">
    <form method="GET" action="{{ route('admin.invoices.index') }}">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
            <!-- Search -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">Search</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Invoice ID or Customer Name"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <!-- Status Filter -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">Status</label>
                <select name="status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_process" {{ request('status') == 'in_process' ? 'selected' : '' }}>In Process</option>
                    <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">From</label>
                <input type="date"
                       name="date_from"
                       value="{{ request('date_from') }}"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <!-- Date To -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">To</label>
                <input type="date"
                       name="date_to"
                       value="{{ request('date_to') }}"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 5px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; white-space: nowrap;">
                    Filter
                </button>
                <a href="{{ route('admin.invoices.index') }}"
                   class="btn"
                   style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; display: inline-block;">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Invoices Table -->
<div class="section">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Weight</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr>
                    <td>
                        <strong>INV-{{ str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }}</strong>
                    </td>
                    <td>{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div>{{ $invoice->customer_name }}</div>
                        <small style="color: #999;">{{ $invoice->phone }}</small>
                    </td>
                    <td>{{ Str::limit($invoice->items, 25) }}</td>
                    <td>{{ $invoice->weight }} kg</td>
                    <td>
                        <strong>Rp {{ number_format($invoice->total, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <span class="badge {{ $invoice->status }}">
                            {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                        </span>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="{{ route('admin.invoices.show', $invoice) }}"
                           class="btn btn-sm"
                           style="background: #17a2b8; color: white; padding: 5px 10px; font-size: 12px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 5px;">
                            View
                        </a>
                        <a href="{{ route('admin.invoices.print', $invoice) }}"
                           target="_blank"
                           class="btn btn-sm"
                           style="background: #28a745; color: white; padding: 5px 10px; font-size: 12px; text-decoration: none; border-radius: 5px; display: inline-block;">
                            Print
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                        No invoices found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($invoices->hasPages())
    <div style="margin-top: 20px;">
        {{ $invoices->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
