@extends('layouts.user')

@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Profile Information -->
    <div class="section" style="margin-bottom: 20px;">
        <h3 style="font-size: 18px; margin-bottom: 20px; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            PROFILE INFORMATION
        </h3>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                    Full Name *
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                @error('name')
                    <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                    Email Address *
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                @error('email')
                    <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div style="margin-top: 10px; padding: 10px; background: #fff3cd; border-radius: 5px; font-size: 14px;">
                        <p style="color: #856404; margin-bottom: 10px;">Your email address is unverified.</p>
                        <form method="POST" action="{{ route('verification.send') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="color: #856404; text-decoration: underline; background: none; border: none; cursor: pointer;">
                                Click here to re-send the verification email.
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Phone -->
            <div class="form-group" style="margin-bottom: 30px;">
                <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                    Phone Number
                </label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                @error('phone')
                    <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Save Button -->
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="section" style="margin-bottom: 20px;">
        <h3 style="font-size: 18px; margin-bottom: 20px; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            UPDATE PASSWORD
        </h3>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="current_password" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                    Current Password *
                </label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                @error('current_password')
                    <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- New Password -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                    New Password *
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                <small style="color: #666; font-size: 12px;">Minimum 6 characters</small>
                @error('password')
                    <span style="color: #dc3545; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group" style="margin-bottom: 30px;">
                <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">
                    Confirm New Password *
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
            </div>

            <!-- Save Button -->
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Account -->
    <div class="section" style="border: 2px solid #dc3545;">
        <h3 style="font-size: 18px; margin-bottom: 15px; color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px;">
            ⚠️ DANGER ZONE
        </h3>

        <p style="color: #666; margin-bottom: 20px; line-height: 1.6;">
            Once your account is deleted, all of its resources and data will be permanently deleted.
            Before deleting your account, please download any data or information that you wish to retain.
        </p>

        <button
            type="button"
            onclick="if(confirm('Are you sure you want to delete your account? This action cannot be undone!')) { document.getElementById('delete-form').submit(); }"
            class="btn"
            style="background: #dc3545; color: white; padding: 12px 30px;">
            Delete Account
        </button>

        <form id="delete-form" method="POST" action="{{ route('profile.destroy') }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@if(session('status') === 'profile-updated')
    <script>
        alert('Profile updated successfully!');
    </script>
@endif

@if(session('status') === 'password-updated')
    <script>
        alert('Password updated successfully!');
    </script>
@endif
@endsection
