<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <h2 class="auth-title">Create Your Account</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Full Name</label>
            <div class="input-wrapper">
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Full Name"
                    required
                    autofocus
                    autocomplete="name">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-wrapper">
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email Address"
                    required
                    autocomplete="username">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Phone -->
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <div class="input-wrapper">
                <input
                    id="phone"
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Phone Number"
                    required>
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            @error('phone')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Password (min 6 characters)"
                    required
                    autocomplete="new-password">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <div class="input-wrapper">
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    required
                    autocomplete="new-password">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            @error('password_confirmation')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn">
            Register
        </button>

        <!-- Login Link -->
        <div class="form-footer">
            Already have an account?
            <a href="{{ route('login') }}">Login here</a>
        </div>
    </form>
</x-guest-layout>
