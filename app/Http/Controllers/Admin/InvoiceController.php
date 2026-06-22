<?php
// File: app/Http/Controllers/Admin/InvoiceController.php
// Fungsi: Manage invoices (admin)

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Tampilkan semua invoices
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }


// Search by customer name or invoice ID
        if ($request->has('search') && $request->search) {
            $search = $request->search;

            // Strip prefix INV- kalau user ngetik format INV-001
            $searchId = preg_replace('/^INV-0*/i', '', trim($search));

            $query->where(function ($q) use ($search, $searchId) {
                $q->where('customer_name', 'like', "%{$search}%")
                ->orWhere('id', $searchId);
            });
        }

        $invoices = $query->paginate(20);

        // Calculate totals
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $pendingRevenue = Order::whereIn('status', ['pending', 'in_process', 'ready'])->sum('total');

        return view('admin.invoices.index', compact('invoices', 'totalRevenue', 'pendingRevenue'));
    }

    // Detail invoice
    public function show(Order $invoice)
    {
        $invoice->load('user');
        return view('admin.invoices.show', compact('invoice'));
    }

    // Print invoice
    public function print(Order $invoice)
    {
        return view('admin.orders.print', ['order' => $invoice]);
    }
}
