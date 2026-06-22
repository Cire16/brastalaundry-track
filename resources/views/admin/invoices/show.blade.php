@extends('layouts.admin')

@section('title', 'Invoice Detail')
@section('page-title', 'Invoice Detail')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('admin.invoices.index') }}" style="color: #3d2e2e; text-decoration: none; font-weight: 600;">
            ← Back to Invoices
        </a>
        <a href="{{ route('admin.invoices.print', $invoice) }}"
           target="_blank"
           class="btn btn-primary">
            🖨️ Print Invoice
        </a>
    </div>

    <!-- Invoice Header Card -->
    <div class="stat-card dark" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h3 style="font-size: 14px; opacity: 0.8; margin-bottom: 10px;">INVOICE NUMBER</h3>
                <div style="font-size: 36px; font-weight: bold; margin-bottom: 10px;">
                    INV-{{ str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }}
                </div>
                <div style="opacity: 0.9;">
                    Issued: {{ $invoice->created_at->format('l, d F Y - h:i A') }}
                </div>
            </div>
            <div style="text-align: right;">
                <span class="badge {{ $invoice->status }}" style="font-size: 14px; padding: 8px 16px;">
                    {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Customer & Order Info -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <!-- Customer Info -->
        <div class="section">
            <h3 style="font-size: 16px; margin-bottom: 15px; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
                CUSTOMER INFORMATION
            </h3>
            <div style="margin-bottom: 10px;">
                <div style="font-size: 12px; color: #666; margin-bottom: 3px;">Name</div>
                <div style="font-weight: 600;">{{ $invoice->customer_name }}</div>
            </div>
            <div style="margin-bottom: 10px;">
                <div style="font-size: 12px; color: #666; margin-bottom: 3px;">Phone</div>
                <div style="font-weight: 600;">{{ $invoice->phone }}</div>
            </div>
            <div>
                <div style="font-size: 12px; color: #666; margin-bottom: 3px;">Email</div>
                <div style="font-weight: 600;">{{ $invoice->user->email }}</div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="section">
            <h3 style="font-size: 16px; margin-bottom: 15px; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
                ORDER SUMMARY
            </h3>
            <div style="margin-bottom: 10px;">
                <div style="font-size: 12px; color: #666; margin-bottom: 3px;">Service Type</div>
                <div style="font-weight: 600;">{{ $invoice->service }}</div>
            </div>
            <div style="margin-bottom: 10px;">
                <div style="font-size: 12px; color: #666; margin-bottom: 3px;">Weight</div>
                <div style="font-weight: 600;">{{ $invoice->weight }} kg</div>
            </div>
            <div>
                <div style="font-size: 12px; color: #666; margin-bottom: 3px;">Price per kg</div>
                <div style="font-weight: 600;">Rp {{ number_format($invoice->price, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Items Detail -->
    <div class="section" style="margin-bottom: 20px;">
        <h3 style="font-size: 16px; margin-bottom: 15px; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            ITEMS DETAIL
        </h3>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
            <p style="font-weight: 600; color: #333;">{{ $invoice->items }}</p>
        </div>
    </div>

    <!-- Price Breakdown -->
    <div class="section">
        <h3 style="font-size: 16px; margin-bottom: 15px; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            PRICE BREAKDOWN
        </h3>

        <table style="width: 100%; margin-bottom: 20px;">
            <tbody>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                        {{ $invoice->service }}
                    </td>
                    <td style="text-align: right; padding: 10px 0; border-bottom: 1px solid #eee;">
                        {{ $invoice->weight }} kg × Rp {{ number_format($invoice->price, 0, ',', '.') }}
                    </td>
                    <td style="text-align: right; padding: 10px 0; border-bottom: 1px solid #eee; font-weight: 600;">
                        Rp {{ number_format($invoice->total, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="background: #d4b5a8; padding: 20px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 20px; font-weight: bold; color: #3d2e2e;">TOTAL AMOUNT</span>
            <span style="font-size: 32px; font-weight: bold; color: #3d2e2e;">
                Rp {{ number_format($invoice->total, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <!-- Pickup Info -->
    @if($invoice->estimated_pickup)
    <div style="margin-top: 20px; padding: 20px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
        <strong style="color: #856404;">📅 Estimated Pickup:</strong>
        <div style="font-size: 18px; font-weight: 600; color: #856404; margin-top: 5px;">
            {{ $invoice->estimated_pickup->format('l, d F Y - h:i A') }}
        </div>
    </div>
    @endif
</div>
@endsection
