<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #333;
            padding: 30px;
        }

        /* Header */
        .report-header {
            text-align: center;
            border-bottom: 3px solid #3d2e2e;
            padding-bottom: 18px;
            margin-bottom: 24px;
        }
        .report-header h1 { font-size: 22px; color: #3d2e2e; letter-spacing: 2px; margin-bottom: 4px; }
        .report-header .subtitle { font-size: 13px; color: #666; }
        .report-header .period {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 18px;
            background: #3d2e2e;
            color: #fff;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
        }

        /* Meta */
        .meta { font-size: 11px; color: #888; text-align: right; margin-bottom: 20px; }

        /* Stats grid */
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 24px;
            border-collapse: separate;
            border-spacing: 8px;
        }
        .stats-row { display: table-row; }
        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 16px 14px;
            border-radius: 8px;
            vertical-align: middle;
            text-align: center;
        }
        .stat-box.dark  { background: #3d2e2e; color: #fff; }
        .stat-box.green { background: #28a745; color: #fff; }
        .stat-box.blue  { background: #17a2b8; color: #fff; }
        .stat-box.beige { background: #d4b5a8; color: #333; }
        .stat-box .label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85; margin-bottom: 6px; }
        .stat-box .val   { font-size: 22px; font-weight: 700; line-height: 1; }
        .stat-box .small { font-size: 10px; opacity: 0.75; margin-top: 4px; }

        /* Section title */
        h2 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #3d2e2e;
            border-left: 4px solid #3d2e2e;
            padding-left: 10px;
            margin-bottom: 12px;
        }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        table thead th {
            background: #3d2e2e;
            color: #fff;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            text-align: left;
        }
        table tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }
        table tbody tr:nth-child(even) td { background: #faf9f7; }

        /* Progress bar (CSS-based, dompdf compatible) */
        .bar-wrap { background: #eee; height: 10px; border-radius: 5px; margin-top: 4px; }
        .bar-fill  { height: 10px; border-radius: 5px; }

        /* Footer */
        .report-footer {
            margin-top: 30px;
            padding-top: 14px;
            border-top: 2px dashed #ccc;
            text-align: center;
            font-size: 11px;
            color: #999;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="report-header">
        <h1>LAUNDRY TRACK</h1>
        <div class="subtitle">Laporan Bisnis</div>
        <div class="period">{{ $periodLabel }}</div>
    </div>

    <div class="meta">Digenerate: {{ $generatedAt }}</div>

    {{-- Summary Stats --}}
    <table class="stats-grid">
        <tr class="stats-row">
            <td class="stat-box dark">
                <div class="label">Total Orders</div>
                <div class="val">{{ $totalOrders }}</div>
                <div class="small">{{ $dateFrom }} – {{ $dateTo }}</div>
            </td>
            <td class="stat-box green">
                <div class="label">Total Revenue</div>
                <div class="val" style="font-size: 16px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="small">Order selesai</div>
            </td>
            <td class="stat-box blue">
                <div class="label">Total Berat</div>
                <div class="val">{{ number_format($totalWeight, 1) }} kg</div>
                <div class="small">Semua order</div>
            </td>
            <td class="stat-box beige">
                <div class="label">Total Customer</div>
                <div class="val">{{ $totalCustomers }}</div>
                <div class="small">Terdaftar</div>
            </td>
        </tr>
    </table>

    {{-- Orders by Status --}}
    @if($ordersByStatus->count() > 0)
    <h2>Status Order</h2>
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordersByStatus as $item)
            <tr>
                <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $item->status) }}</td>
                <td><strong>{{ $item->total }}</strong></td>
                <td>{{ $totalOrders > 0 ? round(($item->total / $totalOrders) * 100) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Revenue by Service --}}
    @if($revenueByService->count() > 0)
    <h2>Revenue per Layanan</h2>
    <table>
        <thead>
            <tr>
                <th>Layanan</th>
                <th>Jumlah Order</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByService as $service)
            <tr>
                <td><strong>{{ $service->service }}</strong></td>
                <td>{{ $service->orders }}</td>
                <td style="color: #28a745; font-weight: 700;">
                    Rp {{ number_format($service->revenue, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Top Customers --}}
    @if($topCustomers->count() > 0)
    <h2>Top 10 Customer</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Total Order</th>
                <th>Total Spent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topCustomers as $i => $customer)
            <tr>
                <td><strong>{{ $i + 1 }}</strong></td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->orders_count }}</td>
                <td style="font-weight: 700; color: #28a745;">
                    Rp {{ number_format($customer->orders_sum_total ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="report-footer">
        Dokumen ini digenerate otomatis oleh sistem Laundry Track &bull; {{ $generatedAt }}
    </div>

</body>
</html>
