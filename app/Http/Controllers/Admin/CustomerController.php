<?php
// File: app/Http/Controllers/Admin/CustomerController.php
// Fungsi: Manage customers (admin)

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Tampilkan semua customers
    public function index()
    {
        $customers = User::where('role', 'user')
            ->withCount('orders')
            ->latest()
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    // Form create customer
    public function create()
    {
        return view('admin.customers.create');
    }

    // Simpan customer baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    // Detail customer
    public function show(User $customer)
    {
        // Pastikan yang ditampilkan adalah user biasa, bukan admin
        if ($customer->role !== 'user') {
            abort(404);
        }

        $orders = $customer->orders()->latest()->paginate(10);

        return view('admin.customers.show', compact('customer', 'orders'));
    }

    // Hapus customer
    public function destroy(User $customer)
    {
        // Pastikan yang dihapus adalah user biasa
        if ($customer->role !== 'user') {
            return redirect()->back()->with('error', 'Cannot delete admin account!');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil dihapus!');
    }
}
