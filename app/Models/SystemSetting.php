<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel system_settings untuk pengaturan sistem global
     * Types: text, image, boolean, json
     */

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    /**
     * NOTE: Ambil nilai setting berdasarkan key
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    /**
     * NOTE: Set nilai setting
     */
    public static function setValue(string $key, $value, string $type = 'text', string $group = 'general'): self
    {
        $storedValue = match ($type) {
            'boolean' => $value ? 'true' : 'false',
            'json' => json_encode($value),
            default => $value,
        };

        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $storedValue, 'type' => $type, 'group' => $group]
        );
    }

    /**
     * NOTE: Ambil semua settings berdasarkan group
     */
    public static function getByGroup(string $group): array
    {
        return self::where('group', $group)
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => self::getValue($setting->key)];
            })
            ->toArray();
    }
}
