<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Form konfirmasi pickup — admin input berat & pilih service
     */
    public function edit(Order $order)
    {
        $services = LaundryService::active()->get();

        return view('admin.orders.confirm', compact('order', 'services'));
    }

    /**
     * Simpan konfirmasi pickup: hitung harga dari DB service
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'weight'           => 'required|numeric|min:0.1',
            'service_id'       => 'required|exists:laundry_services,id',
            'estimated_pickup' => 'required|date|after:now',
        ]);

        $service = LaundryService::findOrFail($request->service_id);
        $total   = $request->weight * $service->price_per_kg;

        $order->update([
            'weight'           => $request->weight,
            'service'          => $service->name,
            'price'            => $service->price_per_kg,
            'total'            => $total,
            'estimated_pickup' => $request->estimated_pickup,
            'is_confirmed'     => true,
            'confirmed_at'     => now(),
            'status'           => 'in_process',
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pickup dikonfirmasi! Berat, harga & jadwal selesai berhasil diset.');
    }

    public function create()
    {
        $users    = User::where('role', 'user')->get();
        $services = LaundryService::active()->get();

        return view('admin.orders.create', compact('users', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'customer_name'    => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'items'            => 'required|string',
            'weight'           => 'required|numeric|min:0.1',
            'service_id'       => 'required|exists:laundry_services,id',
            'estimated_pickup' => 'nullable|date',
        ]);

        $service = LaundryService::findOrFail($request->service_id);
        $total   = $request->weight * $service->price_per_kg;

        Order::create([
            'user_id'          => $request->user_id ?? null,
            'customer_name'    => $request->customer_name,
            'phone'            => $request->phone,
            'items'            => $request->items,
            'weight'           => $request->weight,
            'service'          => $service->name,
            'price'            => $service->price_per_kg,
            'total'            => $total,
            'status'           => 'in_process',
            'is_confirmed'     => true,
            'confirmed_at'     => now(),
            'estimated_pickup' => $request->estimated_pickup,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,in_process,ready,completed',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status order berhasil diupdate!');
    }

    public function editEstimated(Order $order)
    {
        abort_if(!$order->is_confirmed, 403, 'Order belum dikonfirmasi.');
        abort_if(!in_array($order->status, ['in_process']), 403, 'Estimasi hanya bisa diubah saat status In Process.');

        return view('admin.orders.edit-estimated', compact('order'));
    }

    public function updateEstimated(Request $request, Order $order)
    {
        $request->validate([
            'estimated_pickup' => 'required|date',
            'pickup_note'      => 'nullable|string|max:500',
        ]);

        $order->update([
            'estimated_pickup' => $request->estimated_pickup,
            'pickup_note'      => $request->pickup_note,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Estimasi pickup berhasil diupdate!');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order berhasil dihapus!');
    }

    public function print(Order $order)
    {
        return view('admin.orders.print', compact('order'));
    }
}
