<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders    = Order::count();
        $inProcess      = Order::whereIn('status', ['pending', 'in_process'])->count();
        $completedToday = Order::where('status', 'completed')
                               ->whereDate('updated_at', today())
                               ->count();
        $recentOrders   = Order::with('user')->latest()->take(5)->get();
        $recentInvoices = Order::with('user')->latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'inProcess',
            'completedToday',
            'recentOrders',
            'recentInvoices'
        ));
    }
}
