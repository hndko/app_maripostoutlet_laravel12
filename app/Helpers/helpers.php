<?php

use App\Models\SystemSetting;

/**
 * NOTE: Helper functions untuk aplikasi
 */

if (!function_exists('setting')) {
    /**
     * NOTE: Ambil nilai system setting
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return SystemSetting::getValue($key, $default);
    }
}

if (!function_exists('formatRupiah')) {
    /**
     * NOTE: Format angka ke format Rupiah
     * @param float|int $amount
     * @param bool $withSymbol
     * @return string
     */
    function formatRupiah($amount, bool $withSymbol = true): string
    {
        $symbol = $withSymbol ? (setting('currency_symbol', 'Rp') . ' ') : '';
        return $symbol . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('getDefaultImage')) {
    /**
     * NOTE: Get default image path
     * @param string $type (user, product, outlet, category)
     * @return string
     */
    function getDefaultImage(string $type = 'default'): string
    {
        $defaults = [
            'user' => 'assets/backend/img/default-user.png',
            'product' => 'assets/backend/img/default-product.png',
            'outlet' => 'assets/backend/img/default-outlet.png',
            'category' => 'assets/backend/img/default-category.png',
            'default' => 'assets/backend/img/default.png',
        ];

        return asset($defaults[$type] ?? $defaults['default']);
    }
}

if (!function_exists('getImageUrl')) {
    /**
     * NOTE: Get image URL from storage or default
     * @param string|null $path
     * @param string $type
     * @return string
     */
    function getImageUrl(?string $path, string $type = 'default'): string
    {
        if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return \Illuminate\Support\Facades\Storage::url($path);
        }

        return getDefaultImage($type);
    }
}

if (!function_exists('logActivity')) {
    /**
     * NOTE: Log aktivitas user
     * @param string $action
     * @param string $module
     * @param string|null $description
     * @param array|null $oldData
     * @param array|null $newData
     * @return void
     */
    function logActivity(
        string $action,
        string $module,
        ?string $description = null,
        ?array $oldData = null,
        ?array $newData = null
    ): void {
        \App\Models\UserActivityLog::log($action, $module, $description, $oldData, $newData);
    }
}
