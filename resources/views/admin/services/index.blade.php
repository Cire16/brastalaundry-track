@extends('layouts.admin')

@section('title', 'Manage Services')
@section('page-title', 'Layanan Laundry')

@section('content')
<div style="margin-bottom: 20px; text-align: right;">
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">+ Tambah Layanan</a>
</div>

<div class="section">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Nama Layanan</th>
                    <th>Harga / kg</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td>{{ $service->sort_order }}</td>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td>Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}</td>
                    <td>{{ $service->description ?? '-' }}</td>
                    <td>
                        @if($service->is_active)
                            <span class="badge ready">Aktif</span>
                        @else
                            <span class="badge completed">Nonaktif</span>
                        @endif
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="{{ route('admin.services.edit', $service) }}"
                           class="btn btn-sm btn-info">Edit</a>

                        <form action="{{ route('admin.services.destroy', $service) }}"
                              method="POST"
                              style="display: inline;"
                              onsubmit="return confirm('Hapus layanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                        Belum ada layanan.
                        <a href="{{ route('admin.services.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="alert alert-success" style="margin-top: 10px;">
    💡 Layanan yang dinonaktifkan tidak akan muncul di form order customer maupun admin.
</div>
@endsection
