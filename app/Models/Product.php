<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'brand_id',
        'category_id',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function getDefaultVariationAttribute()
    {
        $defaultInStock = $this->variations->firstWhere(function ($variation) {
            return $variation->is_default && $variation->stock > 0;
        });

        if ($defaultInStock) {
            return $defaultInStock;
        }

        $anyInStock = $this->variations->firstWhere('stock', '>', 0);

        if ($anyInStock) {
            return $anyInStock;
        }

        return $this->variations->firstWhere('is_default', true) ?? $this->variations->first();
    }

    /**
     * Получить URL главного изображения товара (из дефолтной вариации)
     */
    public function getMainImageAttribute(): string
    {
        $defaultVariation = $this->default_variation;

        if ($defaultVariation) {
            return $defaultVariation->main_image_url;
        }

        return asset('assets/images/products/default.svg');
    }

    /**
     * Получить изображения дефолтной вариации
     */
    public function getDefaultVariationImages()
    {
        $defaultVariation = $this->default_variation;
        
        if ($defaultVariation) {
            return $defaultVariation->images;
        }
        
        return collect();
    }

    public static function getForCarousel($categoryId = null, $limit = 9, $itemsPerSlide = 3)
    {
        $query = self::with(['category', 'brand', 'variations'])
            ->active();

        if ($categoryId) {
            $query->byCategory($categoryId);
        }

        $products = $query->limit($limit)->get();

        $products = $products->filter(function ($product) {
            return $product->variations->isNotEmpty();
        });

        $products = $products->sortByDesc(function ($product) {
            $defaultVariation = $product->default_variation;
            if ($defaultVariation && $defaultVariation->stock > 0) {
                return 3;
            } elseif ($defaultVariation) {
                return 2;
            } elseif ($product->variations->firstWhere('stock', '>', 0)) {
                return 1;
            }
            return 0;
        });

        return $products->chunk($itemsPerSlide);
    }

    public function getRatingAttribute(): array
    {
        return [
            'score' => 4.9,
            'count' => 1000
        ];
    }

    public function getMinPriceAttribute(): float
    {
        return $this->variations->min('price') ?? 0;
    }

    public function getMaxPriceAttribute(): float
    {
        return $this->variations->max('price') ?? 0;
    }

    public function getPriceRangeAttribute(): string
    {
        $min = $this->min_price;
        $max = $this->max_price;

        if ($min == $max) {
            return number_format($min, 0, '.', ' ') . ' ₽';
        }

        return 'от ' . number_format($min, 0, '.', ' ') . ' ₽ до ' . number_format($max, 0, '.', ' ') . ' ₽';
    }

    public function getTotalStockAttribute(): int
    {
        return $this->variations->sum('stock');
    }

    public function getHasStockAttribute(): bool
    {
        return $this->total_stock > 0;
    }

    public function getFullNameAttribute(): string
    {
        return $this->brand ? "[{$this->brand->name}] {$this->name}" : $this->name;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}