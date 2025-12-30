<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Mari POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: true }" class="bg-slate-100 text-slate-800 antialiased">

    {{-- Sidebar --}}
    <aside
        class="fixed left-0 top-0 h-screen w-64 bg-primary-950 text-white flex flex-col z-40 transition-transform duration-300"
        :class="{ '-translate-x-full': !sidebarOpen }">
        {{-- Logo --}}
        <div class="h-16 flex items-center justify-center border-b border-white/10 font-bold text-xl">
            <i class="fas fa-cash-register mr-2"></i>
            Mari POS
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-4 overflow-y-auto">
            @yield('sidebar')
        </nav>

        {{-- Footer --}}
        <div class="p-4 border-t border-white/10 text-xs text-slate-400 text-center">
            Handoko x Mari Partner
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">
        {{-- Header --}}
        <header
            class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                    <i class="fas fa-bars text-slate-600"></i>
                </button>
                <h1 class="text-lg font-semibold text-slate-800">@yield('title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-4">
                {{-- User Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-3 hover:bg-slate-100 rounded-lg p-2 transition-colors">
                        <div
                            class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <div class="text-sm font-medium text-slate-800">{{ Auth::user()->name ?? 'User' }}</div>
                            <div class="text-xs text-slate-500">{{ ucfirst(Auth::user()->role ?? 'user') }}</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-2 z-50">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                            <i class="fas fa-user w-4"></i> Profile
                        </a>
                        <hr class="my-2 border-slate-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full">
                                <i class="fas fa-sign-out-alt w-4"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="p-6">
            {{-- Breadcrumb --}}
            @hasSection('breadcrumb')
            <nav class="mb-4 text-sm">
                @yield('breadcrumb')
            </nav>
            @endif

            {{-- Main Content --}}
            @yield('content')
        </div>
    </main>

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