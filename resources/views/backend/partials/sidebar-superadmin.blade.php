{{-- Sidebar Superadmin - Mari POS --}}

<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu</div>

<a href="{{ route('dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-home w-5 text-center"></i>
    <span>Dashboard</span>
</a>

<div class="border-t border-white/10 my-3"></div>
<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Master Data</div>

<a href="{{ route('superadmin.users.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('superadmin.users.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-users w-5 text-center"></i>
    <span>Users</span>
</a>

<div class="border-t border-white/10 my-3"></div>
<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Subscription</div>

<a href="{{ route('superadmin.subscription-packages.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('superadmin.subscription-packages.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-box w-5 text-center"></i>
    <span>Packages</span>
</a>

<a href="{{ route('superadmin.subscriptions.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('superadmin.subscriptions.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-crown w-5 text-center"></i>
    <span>Subscriptions</span>
</a>

<a href="{{ route('superadmin.subscription-payments.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('superadmin.subscription-payments.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-credit-card w-5 text-center"></i>
    <span>Payments</span>
</a>

<div class="border-t border-white/10 my-3"></div>
<div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Settings</div>

<a href="{{ route('superadmin.payment-gateways.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('superadmin.payment-gateways.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-wallet w-5 text-center"></i>
    <span>Payment Gateway</span>
</a>

<a href="{{ route('superadmin.settings.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('superadmin.settings.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-cog w-5 text-center"></i>
    <span>System Settings</span>
</a>

<a href="{{ route('superadmin.activity-logs.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-primary-900 hover:text-white transition-colors {{ request()->routeIs('superadmin.activity-logs.*') ? 'bg-primary-600 text-white' : '' }}">
    <i class="fas fa-history w-5 text-center"></i>
    <span>Activity Logs</span>
</a>