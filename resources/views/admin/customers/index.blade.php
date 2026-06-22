@extends('layouts.admin')

@section('title', 'Customers')
@section('page-title', 'Customers Management')

@section('content')
<div style="margin-bottom: 20px; text-align: right;">
    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">+ Add New Customer</a>
</div>

<div class="section">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Orders</th>
                    <th>Joined Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>#{{ $customer->id }}</td>
                    <td>
                        <strong>{{ $customer->name }}</strong>
                    </td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>
                        <span style="background: #d4b5a8; padding: 4px 12px; border-radius: 20px; font-weight: 600;">
                            {{ $customer->orders_count }} orders
                        </span>
                    </td>
                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                    <td style="white-space: nowrap;">
                        <a href="{{ route('admin.customers.show', $customer) }}"
                           class="btn btn-sm"
                           style="background: #17a2b8; color: white; padding: 5px 10px; font-size: 12px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 5px;">
                            View
                        </a>
                        <form action="{{ route('admin.customers.destroy', $customer) }}"
                              method="POST"
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure? This will delete all customer orders!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm"
                                    style="background: #dc3545; color: white; padding: 5px 10px; font-size: 12px; border-radius: 5px;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                        No customers found. <a href="{{ route('admin.customers.create') }}">Add your first customer</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($customers->hasPages())
    <div style="margin-top: 20px;">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
