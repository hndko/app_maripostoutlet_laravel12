<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel user_activity_logs untuk mencatat aktivitas user
     * Actions: login, logout, create, update, delete, dll
     * Relationships:
     * - user() : user yang melakukan aktivitas
     */

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'old_data',
        'new_data',
        'created_at',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * NOTE: Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * NOTE: Log aktivitas user
     */
    public static function log(
        string $action,
        string $module,
        ?string $description = null,
        ?array $oldData = null,
        ?array $newData = null,
        ?int $userId = null
    ): self {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'old_data' => $oldData,
            'new_data' => $newData,
            'created_at' => now(),
        ]);
    }

    /**
     * NOTE: Log login
     */
    public static function logLogin(int $userId): self
    {
        return self::log('login', 'auth', 'User logged in', null, null, $userId);
    }

    /**
     * NOTE: Log logout
     */
    public static function logLogout(int $userId): self
    {
        return self::log('logout', 'auth', 'User logged out', null, null, $userId);
    }

    /**
     * NOTE: Log create
     */
    public static function logCreate(string $module, array $data, ?int $userId = null): self
    {
        return self::log('create', $module, "Created new {$module}", null, $data, $userId);
    }

    /**
     * NOTE: Log update
     */
    public static function logUpdate(string $module, array $oldData, array $newData, ?int $userId = null): self
    {
        return self::log('update', $module, "Updated {$module}", $oldData, $newData, $userId);
    }

    /**
     * NOTE: Log delete
     */
    public static function logDelete(string $module, array $data, ?int $userId = null): self
    {
        return self::log('delete', $module, "Deleted {$module}", $data, null, $userId);
    }
}
