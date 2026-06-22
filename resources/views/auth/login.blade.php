<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <h2 class="auth-title">Login to Your Account</h2>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
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
                    autofocus
                    autocomplete="username">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            @error('email')
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
                    placeholder="Password"
                    required
                    autocomplete="current-password">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="form-footer-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            @else
                <span></span>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn">
            Login
        </button>

        <!-- Sign Up Link -->
        @if (Route::has('register'))
        <div class="form-footer">
            Don't have you account yet?
            <a href="{{ route('register') }}">Sign Up</a>
        </div>
        @endif
    </form>
</x-guest-layout>
