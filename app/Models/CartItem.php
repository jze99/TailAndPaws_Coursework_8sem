<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'variation_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2'
    ];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }

    /**
     * Получить корзину для текущего пользователя/сессии
     */
    public static function getCartQuery()
    {
        return self::with('variation.product')
            ->where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            });
    }

    /**
     * Получить количество товаров в корзине
     */
    public static function getCount()
    {
        return self::getCartQuery()->sum('quantity');
    }

    /**
     * Получить общую сумму корзины
     */
    public static function getTotal()
    {
        return self::getCartQuery()->get()->sum('total');
    }

    /**
     * Получить товар в корзине по вариации
     */
    public static function findByVariation($variationId)
    {
        return self::getCartQuery()
            ->where('variation_id', $variationId)
            ->first();
    }

    /**
     * Получить товар в корзине по ID
     */
    public static function findCartItem($id)
    {
        return self::getCartQuery()
            ->where('id', $id)
            ->first();
    }

    /**
     * Очистить корзину
     */
    public static function clear()
    {
        return self::getCartQuery()->delete();
    }
}
