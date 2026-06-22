<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Brasta Laundry</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f1ed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 60px;
            background: #f5f1ed;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            line-height: 1.2;
            padding: 10px;
            overflow: hidden;
        }

        .logo-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #3d2e2e;
            color: white;
        }

        .btn-primary:hover {
            background: #2d1e1e;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: #3d2e2e;
            border: 2px solid #3d2e2e;
        }

        .btn-secondary:hover {
            background: #3d2e2e;
            color: white;
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 60px;
            position: relative;
        }

        .hero-content {
            background: white;
            border: 4px solid #3d2e2e;
            border-radius: 20px;
            padding: 30px 50px;
            max-width: 1200px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .hero-content::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 50%;
            background-image: url('{{ asset("images/laundry.jpg") }}');
            background-size: cover;
            background-position: center;
            opacity: 0.85;
            z-index: 0;
        }

        .hero-text {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        .hero-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .hero-brand {
            font-size: 72px;
            font-weight: 900;
            color: #3d2e2e;
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .hero-tagline {
            font-size: 28px;
            font-weight: 700;
            color: #3d2e2e;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        .hero-description {
            font-size: 16px;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .hero-links {
            margin-bottom: 30px;
        }

        .hero-links p {
            margin-bottom: 12px;
            font-size: 15px;
            color: #555;
        }

        .hero-links a {
            color: #6b5b4f;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.3s;
        }

        .hero-links a:hover {
            color: #3d2e2e;
        }

        .cta-button {
            display: inline-block;
            padding: 16px 40px;
            background: #3d2e2e;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .cta-button:hover {
            background: #2d1e1e;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(61, 46, 46, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 20px 30px;
            }

            .logo-image {
                width: 60px;
                height: 60px;
                font-size: 11px;
            }

            .hero {
                padding: 20px 30px;
            }

            .hero-content {
                padding: 50px 40px;
            }

            .hero-content::after {
                opacity: 0.3;
                width: 100%;
            }

            .hero-text {
                max-width: 100%;
            }

            .hero-brand {
                font-size: 48px;
            }

            .hero-tagline {
                font-size: 22px;
            }

            .hero-description {
                font-size: 14px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <div class="logo-image">
                <img src="{{ asset('images/logo.png') }}" alt="Brasta Laundry Logo">
            </div>
        </div>
        <div class="header-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </header>

    <!-- Hero Section -->
    <main class="hero">
        <div class="hero-content">
            <!-- Text Content (Left Side) -->
            <div class="hero-text">
                <h2 class="hero-title">Welcome to</h2>
                <h1 class="hero-brand">BRASTA LAUNDRY</h1>
                <p class="hero-tagline">FRESH KICKS & CLEAN FITS</p>
                <p class="hero-description">Your premium laundry and sneaker care service.</p>

                <div class="hero-links">
                    <p>We're in <a href="https://instagram.com" target="_blank">Instagram ↗</a></p>
                    <p>Watch we're Video in <a href="https://youtube.com" target="_blank">YouTube ↗</a></p>
                </div>

                @guest
                    <a href="{{ route('register') }}" class="cta-button">Get Started</a>
                @else
                    <a href="{{ url('/dashboard') }}" class="cta-button">Go to Dashboard</a>
                @endguest
            </div>

            <!-- Background Image (Right Side) ditambahin via CSS -->
        </div>
    </main>
</body>
</html>
