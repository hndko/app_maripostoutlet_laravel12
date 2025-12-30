<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mari POS - Point of Sales Multi Outlet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-slate-800 antialiased">

    {{-- Navbar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="container mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 text-primary-600 font-bold text-lg">
                <i class="fas fa-cash-register"></i>
                <span>Mari POS</span>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="text-sm text-slate-600 hover:text-primary-600 transition-colors px-3 py-2">Login</a>
                <a href="{{ route('register') }}"
                    class="text-sm px-4 py-2 rounded-lg bg-primary-600 text-white font-medium hover:bg-primary-700 transition-colors">
                    Daftar Gratis
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="pt-24 pb-16 sm:pt-32 sm:pb-24 overflow-hidden">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                {{-- Text --}}
                <div class="flex-1 text-center lg:text-left">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-50 text-primary-600 text-xs font-medium mb-4">
                        <i class="fas fa-rocket"></i> Solusi POS Modern
                    </span>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-4 leading-tight">
                        Kelola Bisnis<br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-accent-600">Multi
                            Outlet</span><br>
                        Lebih Mudah
                    </h1>
                    <p class="text-slate-500 text-base sm:text-lg mb-8 max-w-lg mx-auto lg:mx-0">
                        Sistem POS modern untuk mengelola banyak outlet dalam satu platform. Real-time, powerful, dan
                        mudah digunakan.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-3 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl bg-primary-600 text-white font-semibold hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/30 text-center">
                            <i class="fas fa-rocket mr-2"></i> Mulai Gratis
                        </a>
                        <a href="#features"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-200 text-slate-700 font-medium hover:bg-slate-50 transition-all text-center">
                            <i class="fas fa-play-circle mr-2"></i> Lihat Demo
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div
                        class="flex items-center justify-center lg:justify-start gap-8 mt-10 pt-8 border-t border-slate-100">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-slate-900">500+</div>
                            <div class="text-xs text-slate-500">Outlets</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-slate-900">10K+</div>
                            <div class="text-xs text-slate-500">Transaksi/Hari</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-slate-900">99.9%</div>
                            <div class="text-xs text-slate-500">Uptime</div>
                        </div>
                    </div>
                </div>

                {{-- Illustration --}}
                <div class="flex-1 relative">
                    <div class="relative z-10">
                        {{-- Dashboard Preview Card --}}
                        <div
                            class="bg-white rounded-2xl shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                            <div class="bg-slate-800 px-4 py-2 flex items-center gap-2">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                </div>
                                <div class="flex-1 text-center text-xs text-slate-400">Mari POS Dashboard</div>
                            </div>
                            <div class="p-4 bg-slate-50">
                                {{-- Mini Dashboard --}}
                                <div class="grid grid-cols-3 gap-2 mb-3">
                                    <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                        <div
                                            class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mx-auto mb-1">
                                            <i class="fas fa-store text-sm"></i>
                                        </div>
                                        <div class="text-xs font-bold text-slate-800">5</div>
                                        <div class="text-[10px] text-slate-400">Outlets</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                        <div
                                            class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mx-auto mb-1">
                                            <i class="fas fa-receipt text-sm"></i>
                                        </div>
                                        <div class="text-xs font-bold text-slate-800">248</div>
                                        <div class="text-[10px] text-slate-400">Transaksi</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                        <div
                                            class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mx-auto mb-1">
                                            <i class="fas fa-money-bill text-sm"></i>
                                        </div>
                                        <div class="text-xs font-bold text-slate-800">12.5M</div>
                                        <div class="text-[10px] text-slate-400">Revenue</div>
                                    </div>
                                </div>
                                {{-- Chart placeholder --}}
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <div class="flex items-end justify-between gap-1 h-16">
                                        <div class="w-full h-6 bg-primary-200 rounded-sm"></div>
                                        <div class="w-full h-10 bg-primary-300 rounded-sm"></div>
                                        <div class="w-full h-8 bg-primary-400 rounded-sm"></div>
                                        <div class="w-full h-14 bg-primary-500 rounded-sm"></div>
                                        <div class="w-full h-12 bg-primary-400 rounded-sm"></div>
                                        <div class="w-full h-16 bg-primary-600 rounded-sm"></div>
                                        <div class="w-full h-10 bg-primary-400 rounded-sm"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Decorative elements --}}
                    <div class="absolute -top-8 -right-8 w-32 h-32 bg-primary-100 rounded-full blur-3xl opacity-60">
                    </div>
                    <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-accent-100 rounded-full blur-3xl opacity-60">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="py-16 sm:py-24 bg-slate-50">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-3">Fitur Lengkap</h2>
                <p class="text-slate-500 max-w-xl mx-auto">Semua yang Anda butuhkan untuk mengelola bisnis</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 mb-2">Multi Outlet</h3>
                    <p class="text-sm text-slate-500">Kelola banyak outlet dari satu dashboard terpusat</p>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 mb-2">Real-time Report</h3>
                    <p class="text-sm text-slate-500">Pantau penjualan dan performa bisnis secara real-time</p>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div
                        class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 mb-2">Inventory</h3>
                    <p class="text-sm text-slate-500">Manajemen stok produk dengan notifikasi otomatis</p>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-mobile-alt text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 mb-2">Responsive</h3>
                    <p class="text-sm text-slate-500">Akses dari perangkat apapun, kapanpun</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="bg-gradient-to-r from-primary-600 to-accent-600 rounded-2xl p-8 sm:p-12 text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3">Siap Mengembangkan Bisnis?</h2>
                <p class="text-primary-100 mb-6 max-w-lg mx-auto">Daftar sekarang dan dapatkan akses gratis untuk
                    mencoba semua fitur</p>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-primary-700 font-semibold hover:bg-white/90 transition-all shadow-lg">
                    <i class="fas fa-rocket"></i> Mulai Gratis Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-slate-100 py-8">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <div class="flex items-center justify-center gap-2 text-primary-600 font-bold mb-3">
                <i class="fas fa-cash-register"></i>
                <span>Mari POS</span>
            </div>
            <p class="text-slate-400 text-sm">
                &copy; {{ date('Y') }} Handoko x Mari Partner. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>