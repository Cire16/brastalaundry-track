<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\LaundryService;

class ServiceController extends Controller
{
    public function index()
    {
        $services = LaundryService::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(ServiceRequest $request)
    {
        LaundryService::create([
            'name'         => $request->name,
            'price_per_kg' => $request->price_per_kg,
            'description'  => $request->description,
            'is_active'    => $request->boolean('is_active', true),
            'sort_order'   => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(LaundryService $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, LaundryService $service)
    {
        $service->update([
            'name'         => $request->name,
            'price_per_kg' => $request->price_per_kg,
            'description'  => $request->description,
            'is_active'    => $request->boolean('is_active', true),
            'sort_order'   => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diupdate!');
    }

    public function destroy(LaundryService $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
