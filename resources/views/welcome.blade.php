<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mari POS - Point of Sales Multi Outlet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-primary-900 via-primary-800 to-accent-900 min-h-screen">

    {{-- Navbar --}}
    <nav class="container mx-auto px-4 py-6 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2 text-white font-bold text-xl">
            <i class="fas fa-cash-register"></i>
            Mari POS
        </a>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-white/80 hover:text-white transition-colors">Login</a>
            <a href="{{ route('register') }}"
                class="px-4 py-2 rounded-lg bg-white text-primary-700 font-medium hover:bg-white/90 transition-colors">
                Daftar Gratis
            </a>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="container mx-auto px-4 py-20 text-center">
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
            Kelola Bisnis<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-300 to-accent-300">Multi
                Outlet</span>
        </h1>
        <p class="text-xl text-primary-200 mb-8 max-w-2xl mx-auto">
            Sistem POS modern untuk mengelola banyak outlet dalam satu platform.
            Real-time, mudah, dan powerful.
        </p>
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('register') }}"
                class="px-8 py-3 rounded-xl bg-white text-primary-700 font-bold hover:bg-white/90 transition-all shadow-lg">
                <i class="fas fa-rocket mr-2"></i> Mulai Gratis
            </a>
            <a href="#features"
                class="px-8 py-3 rounded-xl border-2 border-white/30 text-white font-medium hover:bg-white/10 transition-all">
                <i class="fas fa-info-circle mr-2"></i> Pelajari
            </a>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="container mx-auto px-4 py-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-store text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Multi Outlet</h3>
                <p class="text-primary-200">Kelola banyak outlet dari satu dashboard</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Real-time Report</h3>
                <p class="text-primary-200">Laporan penjualan real-time dan detail</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Responsive</h3>
                <p class="text-primary-200">Akses dari mana saja, kapan saja</p>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="container mx-auto px-4 py-8 text-center border-t border-white/10">
        <p class="text-primary-300 text-sm">
            &copy; {{ date('Y') }} Mari POS. Handoko x Mari Partner
        </p>
    </footer>
</body>

</html>