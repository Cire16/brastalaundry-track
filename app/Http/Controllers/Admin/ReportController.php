<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $dateFrom = now()->startOfMonth()->format('Y-m-d');
        $dateTo   = now()->endOfMonth()->format('Y-m-d');

        $data = $this->buildReportData($dateFrom, $dateTo);

        return view('admin.reports.index', array_merge($data, [
            'dateFrom' => $dateFrom,
            'dateTo'   => $dateTo,
        ]));
    }

    // ─── Export PDF ───────────────────────────────────────────────────────────

    /**
     * Export laporan ke PDF berdasarkan periode
     * ?period=monthly|semester|yearly  &  ?month=  &year=  &semester=
     */
    public function exportPdf(Request $request)
    {
        [$dateFrom, $dateTo, $periodLabel] = $this->resolvePeriod($request);

        $data = $this->buildReportData($dateFrom, $dateTo);

        $pdf = Pdf::loadView('admin.reports.pdf', array_merge($data, [
            'dateFrom'    => $dateFrom,
            'dateTo'      => $dateTo,
            'periodLabel' => $periodLabel,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ]))->setPaper('a4', 'portrait');

        $filename = 'laporan-laundry-' . str_replace(' ', '-', strtolower($periodLabel)) . '.pdf';

        return $pdf->download($filename);
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    private function buildReportData(string $dateFrom, string $dateTo): array
    {
        $totalOrders    = Order::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->count();
        $totalRevenue   = Order::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                               ->where('status', 'completed')->sum('total');
        $totalWeight    = Order::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->sum('weight');
        $totalCustomers = User::where('role', 'user')->count();

        $ordersByStatus = Order::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $revenueByService = Order::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->where('status', 'completed')
            ->select('service', DB::raw('SUM(total) as revenue'), DB::raw('COUNT(*) as orders'))
            ->groupBy('service')
            ->orderByDesc('revenue')
            ->get();

        $dailyRevenue = Order::whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topCustomers = User::where('role', 'user')
            ->withCount('orders')
            ->withSum('orders', 'total')
            ->orderByDesc('orders_sum_total')
            ->take(10)
            ->get();

        return compact(
            'totalOrders',
            'totalRevenue',
            'totalWeight',
            'totalCustomers',
            'ordersByStatus',
            'revenueByService',
            'dailyRevenue',
            'topCustomers'
        );
    }

    /**
     * Tentukan rentang tanggal berdasarkan parameter period
     * Return: [dateFrom, dateTo, labelPeriode]
     */
    private function resolvePeriod(Request $request): array
    {
        $period = $request->period ?? 'monthly';
        $year   = (int) ($request->year ?? now()->year);

        switch ($period) {
            case 'yearly':
                $from  = Carbon::create($year, 1, 1)->startOfDay()->format('Y-m-d');
                $to    = Carbon::create($year, 12, 31)->endOfDay()->format('Y-m-d');
                $label = "Tahunan {$year}";
                break;

            case 'semester':
                $sem   = (int) ($request->semester ?? 1);
                $from  = Carbon::create($year, $sem === 1 ? 1 : 7, 1)->format('Y-m-d');
                $to    = Carbon::create($year, $sem === 1 ? 6 : 12, 1)->endOfMonth()->format('Y-m-d');
                $label = "Semester " . ($sem === 1 ? 'I' : 'II') . " {$year}";
                break;

            default: // monthly
                $month = (int) ($request->month ?? now()->month);
                $from  = Carbon::create($year, $month, 1)->format('Y-m-d');
                $to    = Carbon::create($year, $month, 1)->endOfMonth()->format('Y-m-d');
                $label = Carbon::create($year, $month, 1)->translatedFormat('F Y');
                break;
        }

        return [$from, $to, $label];
    }
}
