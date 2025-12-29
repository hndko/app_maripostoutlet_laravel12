<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Owner\DiscountController;
use App\Http\Controllers\Owner\OutletController;
use App\Http\Controllers\Owner\PaymentMethodController;
use App\Http\Controllers\Owner\ProductCategoryController;
use App\Http\Controllers\Owner\ProductController;
use App\Http\Controllers\Owner\CashierController;
use App\Http\Controllers\Owner\SubscriptionController as OwnerSubscriptionController;
use App\Http\Controllers\Owner\TransactionController as OwnerTransactionController;
use App\Http\Controllers\Owner\ReportController;
use App\Http\Controllers\POS\POSController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\SubscriptionPackageController;
use App\Http\Controllers\Superadmin\PaymentGatewayController;
use App\Http\Controllers\Superadmin\SystemSettingController;
use App\Http\Controllers\Superadmin\ActivityLogController;
use App\Http\Controllers\Superadmin\SubscriptionController as SuperadminSubscriptionController;
use App\Http\Controllers\Superadmin\SubscriptionPaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| NOTE: Routes dikelompokkan berdasarkan middleware dan prefix
| - Guest routes: login, register
| - Auth routes: dashboard, profile
| - Superadmin routes: semua fitur admin
| - Owner routes: kelola outlet, produk, kasir, dll
| - Kasir routes: POS/transaksi
|--------------------------------------------------------------------------
*/

// ============================================================================
// GUEST ROUTES
// NOTE: Routes untuk user yang belum login
// ============================================================================
Route::middleware('guest')->group(function () {
    // Landing Page
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register (hanya untuk owner)
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // SSO Callback
    Route::get('/auth/{provider}/redirect', [LoginController::class, 'redirectToProvider'])->name('auth.provider.redirect');
    Route::get('/auth/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('auth.provider.callback');
});

// ============================================================================
// AUTHENTICATED ROUTES
// NOTE: Routes untuk semua user yang sudah login
// ============================================================================
Route::middleware(['auth', 'active'])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard (redirect berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ============================================================================
// SUPERADMIN ROUTES
// NOTE: Routes khusus superadmin untuk mengelola seluruh sistem
// ============================================================================
Route::middleware(['auth', 'active', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {

    // Dashboard Superadmin
    Route::get('/dashboard', [DashboardController::class, 'superadmin'])->name('dashboard');

    // --------------------------------------------------------------------------
    // Master Users
    // NOTE: CRUD semua users (superadmin, owner, kasir)
    // --------------------------------------------------------------------------
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-active', [UserController::class, 'toggleActive'])->name('toggle-active');
    });

    // --------------------------------------------------------------------------
    // Subscription Packages
    // NOTE: CRUD paket langganan (trial, duration, lifetime)
    // --------------------------------------------------------------------------
    Route::prefix('subscription-packages')->name('subscription-packages.')->group(function () {
        Route::get('/', [SubscriptionPackageController::class, 'index'])->name('index');
        Route::get('/create', [SubscriptionPackageController::class, 'create'])->name('create');
        Route::post('/', [SubscriptionPackageController::class, 'store'])->name('store');
        Route::get('/{id}', [SubscriptionPackageController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SubscriptionPackageController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SubscriptionPackageController::class, 'update'])->name('update');
        Route::delete('/{id}', [SubscriptionPackageController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-active', [SubscriptionPackageController::class, 'toggleActive'])->name('toggle-active');
    });

    // --------------------------------------------------------------------------
    // Subscriptions Management
    // NOTE: Kelola subscription semua owner, termasuk buat lifetime
    // --------------------------------------------------------------------------
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', [SuperadminSubscriptionController::class, 'index'])->name('index');
        Route::get('/{id}', [SuperadminSubscriptionController::class, 'show'])->name('show');
        Route::get('/create-lifetime/{owner_id}', [SuperadminSubscriptionController::class, 'createLifetime'])->name('create-lifetime');
        Route::post('/store-lifetime', [SuperadminSubscriptionController::class, 'storeLifetime'])->name('store-lifetime');
    });

    // --------------------------------------------------------------------------
    // Subscription Payments
    // NOTE: Kelola pembayaran langganan (approve/reject manual payment)
    // --------------------------------------------------------------------------
    Route::prefix('subscription-payments')->name('subscription-payments.')->group(function () {
        Route::get('/', [SubscriptionPaymentController::class, 'index'])->name('index');
        Route::get('/{id}', [SubscriptionPaymentController::class, 'show'])->name('show');
        Route::patch('/{id}/approve', [SubscriptionPaymentController::class, 'approve'])->name('approve');
        Route::patch('/{id}/reject', [SubscriptionPaymentController::class, 'reject'])->name('reject');
    });

    // --------------------------------------------------------------------------
    // Payment Gateways
    // NOTE: Kelola konfigurasi Midtrans dan Duitku
    // --------------------------------------------------------------------------
    Route::prefix('payment-gateways')->name('payment-gateways.')->group(function () {
        Route::get('/', [PaymentGatewayController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [PaymentGatewayController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PaymentGatewayController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle-active', [PaymentGatewayController::class, 'toggleActive'])->name('toggle-active');
        Route::patch('/{id}/toggle-sandbox', [PaymentGatewayController::class, 'toggleSandbox'])->name('toggle-sandbox');
    });

    // --------------------------------------------------------------------------
    // System Settings
    // NOTE: Kelola pengaturan sistem (website name, logo, tax, dll)
    // --------------------------------------------------------------------------
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SystemSettingController::class, 'index'])->name('index');
        Route::get('/{group}', [SystemSettingController::class, 'edit'])->name('edit');
        Route::put('/{group}', [SystemSettingController::class, 'update'])->name('update');
    });

    // --------------------------------------------------------------------------
    // Activity Logs
    // NOTE: Lihat semua log aktivitas user
    // --------------------------------------------------------------------------
    Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/{id}', [ActivityLogController::class, 'show'])->name('show');
    });
});

// ============================================================================
// OWNER ROUTES
// NOTE: Routes untuk owner mengelola outlet, produk, kasir, dll
// ============================================================================
Route::middleware(['auth', 'active', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {

    // Dashboard Owner
    Route::get('/dashboard', [DashboardController::class, 'owner'])->name('dashboard');

    // --------------------------------------------------------------------------
    // Subscription (tidak perlu middleware subscription karena ini halaman bayar)
    // NOTE: Owner bisa lihat status subscription dan bayar
    // --------------------------------------------------------------------------
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/', [OwnerSubscriptionController::class, 'index'])->name('index');
        Route::get('/packages', [OwnerSubscriptionController::class, 'packages'])->name('packages');
        Route::get('/checkout/{package_id}', [OwnerSubscriptionController::class, 'checkout'])->name('checkout');
        Route::post('/pay', [OwnerSubscriptionController::class, 'pay'])->name('pay');
        Route::get('/payment/{payment_id}/status', [OwnerSubscriptionController::class, 'paymentStatus'])->name('payment-status');
    });
});

// Owner routes yang butuh subscription aktif
Route::middleware(['auth', 'active', 'role:owner', 'subscription'])->prefix('owner')->name('owner.')->group(function () {

    // --------------------------------------------------------------------------
    // Outlets
    // NOTE: CRUD outlet milik owner
    // --------------------------------------------------------------------------
    Route::prefix('outlets')->name('outlets.')->group(function () {
        Route::get('/', [OutletController::class, 'index'])->name('index');
        Route::get('/create', [OutletController::class, 'create'])->name('create');
        Route::post('/', [OutletController::class, 'store'])->name('store');
        Route::get('/{id}', [OutletController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [OutletController::class, 'edit'])->name('edit');
        Route::put('/{id}', [OutletController::class, 'update'])->name('update');
        Route::delete('/{id}', [OutletController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-active', [OutletController::class, 'toggleActive'])->name('toggle-active');
    });

    // --------------------------------------------------------------------------
    // Product Categories
    // NOTE: CRUD kategori produk per outlet
    // --------------------------------------------------------------------------
    Route::prefix('outlets/{outlet_id}/categories')->name('categories.')->group(function () {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('/', [ProductCategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductCategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductCategoryController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-active', [ProductCategoryController::class, 'toggleActive'])->name('toggle-active');
    });

    // --------------------------------------------------------------------------
    // Products
    // NOTE: CRUD produk per outlet
    // --------------------------------------------------------------------------
    Route::prefix('outlets/{outlet_id}/products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-active', [ProductController::class, 'toggleActive'])->name('toggle-active');
        Route::patch('/{id}/update-stock', [ProductController::class, 'updateStock'])->name('update-stock');
    });

    // --------------------------------------------------------------------------
    // Payment Methods per Outlet
    // NOTE: CRUD metode pembayaran per outlet
    // --------------------------------------------------------------------------
    Route::prefix('outlets/{outlet_id}/payment-methods')->name('payment-methods.')->group(function () {
        Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('create');
        Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PaymentMethodController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PaymentMethodController::class, 'update'])->name('update');
        Route::delete('/{id}', [PaymentMethodController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-active', [PaymentMethodController::class, 'toggleActive'])->name('toggle-active');
    });

    // --------------------------------------------------------------------------
    // Discounts per Outlet
    // NOTE: CRUD diskon per outlet
    // --------------------------------------------------------------------------
    Route::prefix('outlets/{outlet_id}/discounts')->name('discounts.')->group(function () {
        Route::get('/', [DiscountController::class, 'index'])->name('index');
        Route::get('/create', [DiscountController::class, 'create'])->name('create');
        Route::post('/', [DiscountController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DiscountController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DiscountController::class, 'update'])->name('update');
        Route::delete('/{id}', [DiscountController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-active', [DiscountController::class, 'toggleActive'])->name('toggle-active');
    });

    // --------------------------------------------------------------------------
    // Cashiers (Kasir)
    // NOTE: CRUD kasir milik owner
    // --------------------------------------------------------------------------
    Route::prefix('cashiers')->name('cashiers.')->group(function () {
        Route::get('/', [CashierController::class, 'index'])->name('index');
        Route::get('/create', [CashierController::class, 'create'])->name('create');
        Route::post('/', [CashierController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CashierController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CashierController::class, 'update'])->name('update');
        Route::delete('/{id}', [CashierController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-active', [CashierController::class, 'toggleActive'])->name('toggle-active');
    });

    // --------------------------------------------------------------------------
    // Transactions History
    // NOTE: Lihat history transaksi per outlet
    // --------------------------------------------------------------------------
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [OwnerTransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [OwnerTransactionController::class, 'show'])->name('show');
        Route::get('/{id}/print', [OwnerTransactionController::class, 'print'])->name('print');
    });

    // --------------------------------------------------------------------------
    // Reports
    // NOTE: Laporan penjualan, produk, kasir
    // --------------------------------------------------------------------------
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/products', [ReportController::class, 'products'])->name('products');
        Route::get('/cashiers', [ReportController::class, 'cashiers'])->name('cashiers');
    });
});

// ============================================================================
// KASIR/POS ROUTES
// NOTE: Routes untuk kasir (dan owner) mengoperasikan POS
// ============================================================================
Route::middleware(['auth', 'active', 'role:owner,kasir', 'subscription'])->prefix('pos')->name('pos.')->group(function () {

    // --------------------------------------------------------------------------
    // POS (Point of Sales)
    // NOTE: Halaman kasir untuk transaksi
    // --------------------------------------------------------------------------
    Route::get('/', [POSController::class, 'index'])->name('index');
    Route::get('/outlet/{outlet_id}', [POSController::class, 'outlet'])->name('outlet');
    Route::get('/products/{outlet_id}', [POSController::class, 'getProducts'])->name('products');
    Route::post('/check-discount', [POSController::class, 'checkDiscount'])->name('check-discount');
    Route::post('/checkout', [POSController::class, 'checkout'])->name('checkout');
    Route::get('/transaction/{id}/receipt', [POSController::class, 'receipt'])->name('receipt');
});

// ============================================================================
// CALLBACK ROUTES (Payment Gateway)
// NOTE: Routes untuk callback dari payment gateway (Midtrans/Duitku)
// ============================================================================
Route::prefix('callback')->name('callback.')->group(function () {
    Route::post('/midtrans', [OwnerSubscriptionController::class, 'midtransCallback'])->name('midtrans');
    Route::post('/duitku', [OwnerSubscriptionController::class, 'duitkuCallback'])->name('duitku');
});
