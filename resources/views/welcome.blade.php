<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Maripos Outlet') }} - Aplikasi Kasir Modern</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #0ea5e9;
            --accent: #f59e0b;
            --dark: #0f172a;
            --light: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary);
            text-decoration: none;
        }

        .logo i {
            font-size: 1.75rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--dark);
            border: 2px solid #e2e8f0;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Hero */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 8rem 2rem 4rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 50%, #fef3c7 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 80%;
            height: 150%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.3;
            }
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-text p {
            font-size: 1.25rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
        }

        .hero-image .mockup {
            width: 100%;
            max-width: 500px;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .floating-card {
            position: absolute;
            background: white;
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: float 4s ease-in-out infinite;
        }

        .floating-card.card-1 {
            top: 10%;
            right: -20px;
            animation-delay: -1s;
        }

        .floating-card.card-2 {
            bottom: 20%;
            left: -30px;
            animation-delay: -2s;
        }

        .floating-card i {
            width: 40px;
            height: 40px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .floating-card.card-1 i {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .floating-card.card-2 i {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        /* Features */
        .features {
            padding: 6rem 2rem;
            background: white;
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .section-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .features-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--light);
            padding: 2rem;
            border-radius: 1.5rem;
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-card:nth-child(1) .feature-icon {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        .feature-card:nth-child(2) .feature-icon {
            background: rgba(14, 165, 233, 0.1);
            color: var(--secondary);
        }

        .feature-card:nth-child(3) .feature-icon {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .feature-card:nth-child(4) .feature-icon {
            background: rgba(245, 158, 11, 0.1);
            color: var(--accent);
        }

        .feature-card:nth-child(5) .feature-icon {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .feature-card:nth-child(6) .feature-icon {
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.7;
        }

        /* CTA */
        .cta {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            text-align: center;
            color: white;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .cta p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta .btn {
            background: white;
            color: var(--primary);
        }

        .cta .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
        footer {
            padding: 3rem 2rem;
            background: var(--dark);
            color: white;
            text-align: center;
        }

        footer p {
            opacity: 0.7;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-image {
                display: none;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="logo">
            <i class="bi bi-shop"></i>
            <span>Maripos</span>
        </a>
        <div class="nav-links">
            <a href="#features">Fitur</a>
            <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary">
                <i class="bi bi-rocket-takeoff"></i>
                Mulai Gratis
            </a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Kelola Bisnis Lebih Mudah dengan POS Modern</h1>
                <p>Aplikasi kasir all-in-one untuk UMKM Indonesia. Catat penjualan, kelola stok, dan pantau laporan
                    bisnis dari mana saja.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="bi bi-rocket-takeoff"></i>
                        Coba Gratis 14 Hari
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline">
                        <i class="bi bi-play-circle"></i>
                        Lihat Demo
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); width: 100%; aspect-ratio: 4/3; border-radius: 1.5rem; display: flex; align-items: center; justify-content: center;"
                    class="mockup">
                    <i class="bi bi-calculator" style="font-size: 6rem; color: white; opacity: 0.9;"></i>
                </div>
                <div class="floating-card card-1">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>+1,250</strong>
                        <div style="font-size: 0.75rem; color: #64748b;">Transaksi hari ini</div>
                    </div>
                </div>
                <div class="floating-card card-2">
                    <i class="bi bi-graph-up-arrow"></i>
                    <div>
                        <strong>+25%</strong>
                        <div style="font-size: 0.75rem; color: #64748b;">Pertumbuhan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="features">
        <div class="section-header">
            <h2>Fitur Lengkap untuk Bisnis Anda</h2>
            <p>Semua yang Anda butuhkan untuk mengelola bisnis dalam satu aplikasi</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-calculator"></i></div>
                <h3>POS Cepat & Mudah</h3>
                <p>Interface kasir yang intuitif untuk transaksi cepat. Dukung barcode scanner dan printer struk.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-shop"></i></div>
                <h3>Multi Outlet</h3>
                <p>Kelola banyak outlet dalam satu akun. Pantau performa setiap cabang dengan mudah.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-box-seam"></i></div>
                <h3>Manajemen Stok</h3>
                <p>Pantau stok realtime, peringatan stok menipis, dan riwayat pergerakan barang.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-percent"></i></div>
                <h3>Diskon & Promo</h3>
                <p>Buat diskon persentase atau nominal, kode kupon, dan promo otomatis.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-graph-up"></i></div>
                <h3>Laporan Lengkap</h3>
                <p>Analisis penjualan, produk terlaris, dan performa kasir dengan grafik visual.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-credit-card"></i></div>
                <h3>Multi Pembayaran</h3>
                <p>Terima cash, QRIS, transfer bank, hingga e-wallet dalam satu sistem.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <h2>Siap Memulai?</h2>
        <p>Bergabung dengan ribuan UMKM yang sudah menggunakan Maripos untuk mengembangkan bisnis mereka.</p>
        <a href="{{ route('register') }}" class="btn">
            <i class="bi bi-rocket-takeoff"></i>
            Daftar Gratis Sekarang
        </a>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Maripos Outlet. Made with ❤️ in Indonesia</p>
    </footer>
</body>

</html>