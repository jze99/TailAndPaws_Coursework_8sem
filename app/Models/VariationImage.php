<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariationImage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'variation_id',
        'path',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean'
    ];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }

    public function getUrlAttribute(): string
    {
        if ($this->path && file_exists(public_path($this->path))) {
            return asset($this->path);
        }

        return asset('assets/images/products/default.svg');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
