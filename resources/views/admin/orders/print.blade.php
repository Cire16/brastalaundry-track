<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background: white;
        }
        .invoice-header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .invoice-header p {
            font-size: 12px;
            color: #666;
        }
        .invoice-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 14px;
        }
        .invoice-label {
            font-weight: bold;
        }
        .invoice-section {
            margin: 20px 0;
            padding: 15px 0;
            border-top: 1px dashed #000;
        }
        .invoice-total {
            border-top: 2px dashed #000;
            margin-top: 20px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }
        .invoice-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px dashed #000;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-in_process { background: #d1ecf1; color: #0c5460; }
        .status-ready { background: #d4edda; color: #155724; }
        .status-completed { background: #e2e3e5; color: #383d41; }

        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>LAUNDRY TRACK-BRAL</h1>
        <p>Professional Laundry Service</p>
        <p style="margin-top: 10px;">Jl. Leo Mamiri</p>
        <p>Phone: (021) 12345678</p>
    </div>

    <div class="invoice-body">
        <div class="invoice-row">
            <span class="invoice-label">Invoice No:</span>
            <span>INV-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="invoice-row">
            <span class="invoice-label">Date:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="invoice-row">
            <span class="invoice-label">Status:</span>
            <span class="status-badge status-{{ $order->status }}">
                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </span>
        </div>

        <div class="invoice-section">
            <div class="invoice-row">
                <span class="invoice-label">Customer:</span>
                <span>{{ $order->customer_name }}</span>
            </div>
            <div class="invoice-row">
                <span class="invoice-label">Phone:</span>
                <span>{{ $order->phone }}</span>
            </div>
        </div>

        <div class="invoice-section">
            <div style="font-weight: bold; margin-bottom: 10px;">ORDER DETAILS</div>
            <div class="invoice-row">
                <span class="invoice-label">Items:</span>
                <span style="text-align: right; max-width: 60%;">{{ $order->items }}</span>
            </div>
            <div class="invoice-row">
                <span class="invoice-label">Weight:</span>
                <span>{{ $order->weight }} kg</span>
            </div>
            <div class="invoice-row">
                <span class="invoice-label">Service:</span>
                <span>{{ $order->service }}</span>
            </div>
            <div class="invoice-row">
                <span class="invoice-label">Price/kg:</span>
                <span>Rp {{ number_format($order->price, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->estimated_pickup)
        <div class="invoice-section" style="background: #f8f9fa; padding: 10px; border-radius: 5px;">
            <div class="invoice-row">
                <span class="invoice-label">Est. Pickup:</span>
                <span>{{ $order->estimated_pickup->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        @endif

        <div class="invoice-total">
            <div class="invoice-row">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="invoice-footer">
        <p style="margin-bottom: 10px; font-weight: bold;">TERMS & CONDITIONS</p>
        <p>• Items are inspected upon receipt</p>
        <p>• We are not responsible for items left beyond 30 days</p>
        <p>• Please keep this receipt for pickup</p>
        <p style="margin-top: 15px; font-weight: bold;">Thank you for your business! 😊</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px dashed #ccc;">
        <button onclick="window.print()" style="padding: 12px 30px; background: #3d2e2e; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold; margin-right: 10px;">
            🖨️ Print Invoice
        </button>
        <button onclick="window.close()" style="padding: 12px 30px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold;">
            Close
        </button>
    </div>
</body>
</html>
