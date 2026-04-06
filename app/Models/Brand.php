<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'country',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    public function getProductsCountAttribute(): int
    {
        return $this->activeProducts()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->withCount('products')->orderBy('products_count', 'desc');
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            $logoPath = 'assets/images/brands/' . $this->logo;
            if (file_exists(public_path($logoPath))) {
                return asset($logoPath);
            }
        }

        return asset('assets/images/brands/default.svg');
    }
}
