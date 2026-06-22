@extends('layouts.admin')

@section('title', 'Add New Customer')
@section('page-title', 'Add New Customer')

@section('content')
<div class="section" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                Full Name *
            </label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
            @error('name')
                <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                Email Address *
            </label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
            @error('email')
                <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                Phone Number *
            </label>
            <input type="text"
                   id="phone"
                   name="phone"
                   value="{{ old('phone') }}"
                   required
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
            @error('phone')
                <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                Password *
            </label>
            <input type="password"
                   id="password"
                   name="password"
                   required
                   minlength="6"
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
            <small style="color: #666; font-size: 12px;">Minimum 6 characters</small>
            @error('password')
                <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                Confirm Password *
            </label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   required
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <a href="{{ route('admin.customers.index') }}"
               class="btn"
               style="background: #6c757d; color: white; text-decoration: none; padding: 12px 24px;">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary" style="padding: 12px 24px;">
                Add Customer
            </button>
        </div>
    </form>
</div>
@endsection
