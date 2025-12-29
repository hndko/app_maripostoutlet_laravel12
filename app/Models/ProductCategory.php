<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel product_categories untuk kategori produk per outlet
     * Relationships:
     * - outlet() : outlet tempat kategori ini
     * - products() : produk dalam kategori ini
     */

    protected $fillable = [
        'outlet_id',
        'name',
        'description',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * NOTE: Relasi ke outlet
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * NOTE: Relasi ke produk
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
