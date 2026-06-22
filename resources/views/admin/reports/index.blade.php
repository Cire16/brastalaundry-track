@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Business Reports & Analytics')

@section('content')

{{-- ── Export PDF ───────────────────────────────────────────────────────────── --}}
<div class="section" style="margin-bottom: 20px;">
    <h3 style="font-size: 16px; margin-bottom: 18px;">📥 EXPORT LAPORAN PDF</h3>

    {{-- Monthly --}}
    <form method="GET" action="{{ route('admin.reports.export') }}" style="margin-bottom: 16px;">
        <input type="hidden" name="period" value="monthly">
        <div style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">Bulan</label>
                <select name="month" class="form-control" style="min-width: 140px;">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ now()->month === $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">Tahun</label>
                <select name="year" class="form-control">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-danger" style="padding: 10px 22px;">
                📄 Export Bulanan
            </button>
        </div>
    </form>

    <hr style="border: none; border-top: 1px solid #eee; margin: 16px 0;">

    {{-- Semester --}}
    <form method="GET" action="{{ route('admin.reports.export') }}" style="margin-bottom: 16px;">
        <input type="hidden" name="period" value="semester">
        <div style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">Semester</label>
                <select name="semester" class="form-control">
                    <option value="1">Semester I (Jan–Jun)</option>
                    <option value="2">Semester II (Jul–Des)</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">Tahun</label>
                <select name="year" class="form-control">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-danger" style="padding: 10px 22px;">
                📄 Export Semesteran
            </button>
        </div>
    </form>

    <hr style="border: none; border-top: 1px solid #eee; margin: 16px 0;">

    {{-- Yearly --}}
    <form method="GET" action="{{ route('admin.reports.export') }}">
        <input type="hidden" name="period" value="yearly">
        <div style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #666;">Tahun</label>
                <select name="year" class="form-control">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-danger" style="padding: 10px 22px;">
                📄 Export Tahunan
            </button>
        </div>
    </form>
</div>

{{-- ── Summary Stats ────────────────────────────────────────────────────────── --}}
<div class="stats-grid" style="margin-bottom: 30px;">
    <div class="stat-card dark">
        <h3>TOTAL ORDERS</h3>
        <div class="value">{{ $totalOrders }}</div>
        <small>{{ now()->translatedFormat('F Y') }}</small>
    </div>
    <div class="stat-card" style="background: #28a745; color: white;">
        <h3>TOTAL REVENUE</h3>
        <div class="value" style="font-size: 30px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <small>Completed orders only</small>
    </div>
    <div class="stat-card" style="background: #17a2b8; color: white;">
        <h3>TOTAL WEIGHT</h3>
        <div class="value">{{ number_format($totalWeight, 1) }} kg</div>
        <small>All orders combined</small>
    </div>
    <div class="stat-card light">
        <h3>TOTAL CUSTOMERS</h3>
        <div class="value">{{ $totalCustomers }}</div>
        <small>Registered users</small>
    </div>
</div>

{{-- ── Charts row ───────────────────────────────────────────────────────────── --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">

    {{-- Orders by status --}}
    <div class="section">
        <h3>📊 ORDERS BY STATUS</h3>
        @if($ordersByStatus->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @foreach($ordersByStatus as $item)
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: 600; text-transform: capitalize;">
                            {{ str_replace('_', ' ', $item->status) }}
                        </span>
                        <span style="font-weight: 600;">{{ $item->total }} orders</span>
                    </div>
                    <div style="background: #eee; height: 12px; border-radius: 10px; overflow: hidden;">
                        <div style="
                            height: 100%;
                            border-radius: 10px;
                            width: {{ $totalOrders > 0 ? round(($item->total / $totalOrders) * 100) : 0 }}%;
                            background: {{ match($item->status) {
                                'pending'    => '#ffc107',
                                'in_process' => '#17a2b8',
                                'ready'      => '#28a745',
                                default      => '#6c757d'
                            } }};
                        "></div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 40px 0;">No data available</p>
        @endif
    </div>

    {{-- Revenue by service --}}
    <div class="section">
        <h3>💰 REVENUE BY SERVICE</h3>
        @if($revenueByService->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Orders</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revenueByService as $service)
                    <tr>
                        <td><strong>{{ $service->service }}</strong></td>
                        <td>{{ $service->orders }}</td>
                        <td style="font-weight: 600; color: #28a745;">
                            Rp {{ number_format($service->revenue, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #999; padding: 40px 0;">No data available</p>
        @endif
    </div>
</div>

{{-- ── Daily Revenue Chart ──────────────────────────────────────────────────── --}}
<div class="section" style="margin-bottom: 20px;">
    <h3>📈 DAILY REVENUE (Last 7 Days)</h3>
    @if($dailyRevenue->count() > 0)
        @php $maxRevenue = $dailyRevenue->max('revenue'); @endphp
        <div style="display: flex; align-items: flex-end; gap: 10px; height: 200px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            @foreach($dailyRevenue as $day)
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                <div style="font-size: 12px; font-weight: 600; color: #28a745; margin-bottom: 5px;">
                    Rp {{ number_format($day->revenue / 1000, 0) }}K
                </div>
                <div style="
                    width: 100%;
                    background: #28a745;
                    border-radius: 5px 5px 0 0;
                    height: {{ $maxRevenue > 0 ? round(($day->revenue / $maxRevenue) * 150) : 10 }}px;
                    min-height: 10px;
                "></div>
                <div style="margin-top: 8px; font-size: 11px; color: #666; font-weight: 600;">
                    {{ \Carbon\Carbon::parse($day->date)->format('d M') }}
                </div>
                <div style="font-size: 10px; color: #999;">{{ $day->orders }} orders</div>
            </div>
            @endforeach
        </div>
    @else
        <p style="text-align: center; color: #999; padding: 40px 0;">No data available</p>
    @endif
</div>

{{-- ── Top Customers ────────────────────────────────────────────────────────── --}}
<div class="section">
    <h3>🏆 TOP 10 CUSTOMERS (All Time)</h3>
    @if($topCustomers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total Orders</th>
                    <th>Total Spent</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topCustomers as $i => $customer)
                <tr>
                    <td>
                        <strong style="font-size: 18px; color: {{ match($i) { 0 => '#FFD700', 1 => '#C0C0C0', 2 => '#CD7F32', default => '#333' } }};">
                            #{{ $i + 1 }}
                        </strong>
                    </td>
                    <td><strong>{{ $customer->name }}</strong></td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <span class="badge light" style="background: #d4b5a8;">
                            {{ $customer->orders_count }} orders
                        </span>
                    </td>
                    <td style="font-weight: 600; color: #28a745; font-size: 16px;">
                        Rp {{ number_format($customer->orders_sum_total ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #999; padding: 40px 0;">No customers yet</p>
    @endif
</div>

@endsection
