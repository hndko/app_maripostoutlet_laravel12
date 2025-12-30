<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - Mari POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen bg-gradient-to-br from-primary-900 via-primary-800 to-accent-900 flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-white/10 rounded-2xl backdrop-blur-sm mb-4">
                <i class="fas fa-cash-register text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Mari POS</h1>
            <p class="text-primary-200 text-sm">Point of Sales Multi Outlet</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            @yield('content')
        </div>

        {{-- Footer --}}
        <div class="text-center mt-6">
            <p class="text-primary-300 text-xs">
                &copy; {{ date('Y') }} Handoko x Mari Partner
            </p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed top-4 right-4 z-50 p-4 rounded-lg flex items-start gap-3 bg-green-50 text-green-800 border border-green-200 max-w-sm"
        x-transition>
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="fixed top-4 right-4 z-50 p-4 rounded-lg flex items-start gap-3 bg-red-50 text-red-800 border border-red-200 max-w-sm"
        x-transition>
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @stack('scripts')
</body>

</html>