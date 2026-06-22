<?php
// File: app/Http/Controllers/User/DashboardController.php
// Fungsi: Controller untuk dashboard user/customer

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil order yang sedang aktif (belum completed)
        $currentOrder = $user->orders()
            ->whereIn('status', ['pending', 'in_process', 'ready'])
            ->latest()
            ->first();

        // Ambil riwayat order (yang sudah completed)
        $orderHistory = $user->orders()
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('currentOrder', 'orderHistory'));
    }
}
