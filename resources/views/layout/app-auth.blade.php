<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - Mari POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen flex">
        {{-- Left Side - Branding (Hidden on mobile) --}}
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-900 via-primary-800 to-accent-900 p-12 flex-col justify-between">
            <div>
                <a href="/" class="flex items-center gap-3 text-white">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cash-register text-xl"></i>
                    </div>
                    <span class="font-bold text-xl">Mari POS</span>
                </a>
            </div>

            <div>
                <h1 class="text-4xl font-bold text-white mb-4">
                    Point of Sales<br>
                    <span class="text-primary-300">Multi Outlet</span>
                </h1>
                <p class="text-primary-200 text-lg max-w-md">
                    Kelola semua outlet bisnis Anda dalam satu platform yang powerful dan mudah digunakan.
                </p>

                {{-- Features --}}
                <div class="mt-8 space-y-4">
                    <div class="flex items-center gap-3 text-white/80">
                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-store text-sm"></i>
                        </div>
                        <span class="text-sm">Multi Outlet Management</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/80">
                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-sm"></i>
                        </div>
                        <span class="text-sm">Real-time Dashboard & Reports</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/80">
                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-sm"></i>
                        </div>
                        <span class="text-sm">Responsive & Mobile Friendly</span>
                    </div>
                </div>
            </div>

            <div class="text-primary-300 text-xs">
                &copy; {{ date('Y') }} Handoko x Mari Partner
            </div>
        </div>

        {{-- Right Side - Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8">
            <div class="w-full max-w-sm">
                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-primary-600 rounded-xl mb-3">
                        <i class="fas fa-cash-register text-xl text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold text-slate-800">Mari POS</h1>
                </div>

                @yield('content')

                {{-- Mobile Footer --}}
                <div class="lg:hidden text-center mt-8">
                    <p class="text-slate-400 text-xs">&copy; {{ date('Y') }} Handoko x Mari Partner</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed top-4 right-4 z-50 px-4 py-3 rounded-lg flex items-center gap-3 bg-green-50 text-green-800 border border-green-200 text-sm shadow-lg"
        x-transition>
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed top-4 right-4 z-50 px-4 py-3 rounded-lg flex items-center gap-3 bg-red-50 text-red-800 border border-red-200 text-sm shadow-lg"
        x-transition>
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @stack('scripts')
</body>

</html>