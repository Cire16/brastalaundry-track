<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LaundryService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function create()
    {
        $services = LaundryService::active()->get();

        return view('user.orders.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string',
            'items'         => 'required|string',
            'service'       => 'required|string|exists:laundry_services,name',
            'pickup_date'   => 'required|date',
        ]);

        Order::create([
            'user_id'       => auth()->id(),
            'customer_name' => $request->customer_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'items'         => $request->items,
            'service'       => $request->service,
            'pickup_date'   => $request->pickup_date,
            'status'        => 'pending',
            'is_confirmed'  => false,
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Pickup request berhasil dibuat! Tunggu konfirmasi dari admin.');
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        return view('user.orders.show', compact('order'));
    }

        /**
     * Form edit pickup request
     * Hanya bisa diedit kalau belum dikonfirmasi admin
     */
    public function edit(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($order->is_confirmed, 403, 'Order sudah dikonfirmasi, tidak bisa diedit.');

        $services = LaundryService::active()->get();

        return view('user.orders.edit', compact('order', 'services'));
    }

    /**
     * Simpan perubahan pickup request
     */
    public function update(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($order->is_confirmed, 403, 'Order sudah dikonfirmasi, tidak bisa diedit.');

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string',
            'items'         => 'required|string',
            'service'       => 'required|string|exists:laundry_services,name',
            'pickup_date'   => 'required|date',
        ]);

        $order->update([
            'customer_name' => $request->customer_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'items'         => $request->items,
            'service'       => $request->service,
            'pickup_date'   => $request->pickup_date,
        ]);

        return redirect()->route('user.orders.show', $order)
            ->with('success', 'Pickup request berhasil diupdate!');
    }

    /**
     * Batalkan pickup request
     * Hanya bisa dibatalkan kalau belum dikonfirmasi admin
     */
    public function destroy(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($order->is_confirmed, 403, 'Order sudah dikonfirmasi, tidak bisa dibatalkan.');

        $order->delete();

        return redirect()->route('user.orders.index')
            ->with('success', 'Pickup request berhasil dibatalkan.');
    }
}
