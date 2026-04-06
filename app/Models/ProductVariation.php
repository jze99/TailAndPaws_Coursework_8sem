<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariation extends Model
{
    protected $table = 'product_variations';

    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'price',
        'old_price',
        'stock',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'float',
        'old_price' => 'float',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(VariationAttribute::class, 'variation_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(VariationImage::class, 'variation_id')
            ->ordered();
    }

    /**
     * Получить URL главного изображения вариации
     */
    public function getMainImageUrlAttribute(): string
    {
        $image = $this->images()->first();

        if ($image) {
            return $image->url;
        }

        return asset('assets/images/products/default.svg');
    }

    /**
     * Получить все изображения вариации
     */
    public function getAllImages()
    {
        return $this->images;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    public function getDiscountPercentAttribute(): int
    {
        if (!$this->has_discount) return 0;
        return round(($this->old_price - $this->price) / $this->old_price * 100);
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, '.', ' ') . ' ₽';
    }

    public function getFormattedOldPriceAttribute(): string
    {
        if (!$this->old_price) return '';
        return number_format($this->old_price, 0, '.', ' ') . ' ₽';
    }

    public static function isSkuUnique($sku, $excludeId = null, $productId = null)
    {
        $query = self::where('sku', $sku);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($productId) {
            $query->where('product_id', $productId);
        }

        return !$query->exists();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeDiscounted($query)
    {
        return $query->whereNotNull('old_price')
            ->whereColumn('old_price', '>', 'price');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // ========== МЕТОДЫ ДЛЯ AJAX ==========

    public static function getImagesByVariationId($variationId)
    {
        $variation = self::with(['images' => function ($query) {
            $query->active()->ordered();
        }])->find($variationId);

        if (!$variation) {
            return collect();
        }

        return $variation->images;
    }

    public static function getImagesDataById($variationId)
    {
        $images = self::getImagesByVariationId($variationId);

        return $images->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => $image->url,
                'sort_order' => $image->sort_order,
                'variation_id' => $image->variation_id
            ];
        });
    }
}
