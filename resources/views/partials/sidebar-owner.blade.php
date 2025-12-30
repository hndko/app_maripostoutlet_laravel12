{{-- NOTE: Sidebar untuk Owner --}}
<div class="nav-section">Menu Utama</div>

<div class="nav-item">
    <a href="{{ route('owner.dashboard') }}"
        class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>
</div>

<div class="nav-item">
    <a href="{{ route('pos.index') }}" class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
        <i class="bi bi-calculator"></i>
        <span>POS / Kasir</span>
    </a>
</div>

<div class="nav-section">Kelola Toko</div>

<div class="nav-item">
    <a href="{{ route('owner.outlets.index') }}"
        class="nav-link {{ request()->routeIs('owner.outlets.*') ? 'active' : '' }}">
        <i class="bi bi-shop"></i>
        <span>Outlet</span>
    </a>
</div>

<div class="nav-item">
    <a href="{{ route('owner.cashiers.index') }}"
        class="nav-link {{ request()->routeIs('owner.cashiers.*') ? 'active' : '' }}">
        <i class="bi bi-person-badge"></i>
        <span>Kasir</span>
    </a>
</div>

<div class="nav-section">Transaksi</div>

<div class="nav-item">
    <a href="{{ route('owner.transactions.index') }}"
        class="nav-link {{ request()->routeIs('owner.transactions.*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i>
        <span>Riwayat Transaksi</span>
    </a>
</div>

<div class="nav-section">Laporan</div>

<div class="nav-item">
    <a href="{{ route('owner.reports.sales') }}"
        class="nav-link {{ request()->routeIs('owner.reports.sales') ? 'active' : '' }}">
        <i class="bi bi-graph-up"></i>
        <span>Laporan Penjualan</span>
    </a>
</div>

<div class="nav-item">
    <a href="{{ route('owner.reports.products') }}"
        class="nav-link {{ request()->routeIs('owner.reports.products') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i>
        <span>Laporan Produk</span>
    </a>
</div>

<div class="nav-section">Langganan</div>

<div class="nav-item">
    <a href="{{ route('owner.subscription.index') }}"
        class="nav-link {{ request()->routeIs('owner.subscription.*') ? 'active' : '' }}">
        <i class="bi bi-star"></i>
        <span>Status Langganan</span>
    </a>
</div>