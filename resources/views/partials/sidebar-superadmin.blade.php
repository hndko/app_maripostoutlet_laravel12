{{-- NOTE: Sidebar untuk Superadmin --}}
<div class="nav-section">Menu Utama</div>

<div class="nav-item">
    <a href="{{ route('superadmin.dashboard') }}"
        class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>
</div>

<div class="nav-section">Master Data</div>

<div class="nav-item">
    <a href="{{ route('superadmin.users.index') }}"
        class="nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>Master Users</span>
    </a>
</div>

<div class="nav-section">Subscription</div>

<div class="nav-item">
    <a href="{{ route('superadmin.subscription-packages.index') }}"
        class="nav-link {{ request()->routeIs('superadmin.subscription-packages.*') ? 'active' : '' }}">
        <i class="bi bi-box"></i>
        <span>Paket Langganan</span>
    </a>
</div>

<div class="nav-item">
    <a href="{{ route('superadmin.subscriptions.index') }}"
        class="nav-link {{ request()->routeIs('superadmin.subscriptions.*') ? 'active' : '' }}">
        <i class="bi bi-card-checklist"></i>
        <span>Daftar Langganan</span>
    </a>
</div>

<div class="nav-item">
    <a href="{{ route('superadmin.subscription-payments.index') }}"
        class="nav-link {{ request()->routeIs('superadmin.subscription-payments.*') ? 'active' : '' }}">
        <i class="bi bi-credit-card"></i>
        <span>Pembayaran</span>
        @php
        $pendingCount = \App\Models\SubscriptionPayment::where('status', 'pending')->count();
        @endphp
        @if($pendingCount > 0)
        <span class="badge bg-danger ms-auto">{{ $pendingCount }}</span>
        @endif
    </a>
</div>

<div class="nav-section">Pengaturan</div>

<div class="nav-item">
    <a href="{{ route('superadmin.payment-gateways.index') }}"
        class="nav-link {{ request()->routeIs('superadmin.payment-gateways.*') ? 'active' : '' }}">
        <i class="bi bi-wallet2"></i>
        <span>Payment Gateways</span>
    </a>
</div>

<div class="nav-item">
    <a href="{{ route('superadmin.settings.index') }}"
        class="nav-link {{ request()->routeIs('superadmin.settings.*') ? 'active' : '' }}">
        <i class="bi bi-gear"></i>
        <span>Pengaturan Sistem</span>
    </a>
</div>

<div class="nav-item">
    <a href="{{ route('superadmin.activity-logs.index') }}"
        class="nav-link {{ request()->routeIs('superadmin.activity-logs.*') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i>
        <span>Log Aktivitas</span>
    </a>
</div>