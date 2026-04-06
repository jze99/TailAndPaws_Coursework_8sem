<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'variation_id',
        'product_name',
        'variation_name',
        'sku',
        'quantity',
        'price',
        'total'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public static function createFromCartItem($orderId, $cartItem)
    {
        return self::create([
            'order_id' => $orderId,
            'variation_id' => $cartItem->variation_id,
            'product_name' => $cartItem->variation->product->name,
            'variation_name' => $cartItem->variation->name,
            'sku' => $cartItem->variation->sku,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->price,
            'total' => $cartItem->total
        ]);
    }

    public function scopePopular($query, $limit = 5)
    {
        return $query->select(
            'product_name',
            'variation_name',
            'variation_id',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(total) as total_revenue')
        )
            ->groupBy('product_name', 'variation_name', 'variation_id')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit);
    }
}
