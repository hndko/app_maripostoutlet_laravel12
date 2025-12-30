{{-- Sidebar Owner - Mari POS --}}

<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu</div>

<a href="{{ route('dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-home w-5 text-center"></i>
    <span>Dashboard</span>
</a>

<a href="{{ route('pos.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('pos.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-cash-register w-5 text-center"></i>
    <span>POS</span>
</a>

<div class="border-t border-white/10 my-3"></div>
<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Kelola Bisnis</div>

<a href="{{ route('owner.outlets.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('owner.outlets.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-store w-5 text-center"></i>
    <span>Outlets</span>
</a>

<a href="{{ route('owner.cashiers.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('owner.cashiers.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-user-tie w-5 text-center"></i>
    <span>Kasir</span>
</a>

<div class="border-t border-white/10 my-3"></div>
<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Transaksi</div>

<a href="{{ route('owner.transactions.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('owner.transactions.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-receipt w-5 text-center"></i>
    <span>Riwayat Transaksi</span>
</a>

<div class="border-t border-white/10 my-3"></div>
<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Laporan</div>

<a href="{{ route('owner.reports.sales') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('owner.reports.sales') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-chart-line w-5 text-center"></i>
    <span>Laporan Penjualan</span>
</a>

<a href="{{ route('owner.reports.products') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('owner.reports.products') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-chart-bar w-5 text-center"></i>
    <span>Laporan Produk</span>
</a>

<div class="border-t border-white/10 my-3"></div>
<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Akun</div>

<a href="{{ route('owner.subscription.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('owner.subscription.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-crown w-5 text-center"></i>
    <span>Subscription</span>
</a>