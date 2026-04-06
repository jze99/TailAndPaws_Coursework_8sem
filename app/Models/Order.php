<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'subtotal',
        'shipping_cost',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'delivery_method',
        'delivery_status',
        'comment'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    const DELIVERY_STATUSES = [
        'pending' => 'Ожидает обработки',
        'processing' => 'В обработке',
        'shipped' => 'Отправлен',
        'delivered' => 'Доставлен',
        'cancelled' => 'Отменён'
    ];

    const PAYMENT_STATUSES = [
        'pending' => 'Ожидает оплаты',
        'paid' => 'Оплачен',
        'failed' => 'Ошибка оплаты'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    /**
     * Создать заказ из корзины
     */
    public static function createFromCart($data, $cartItems)
    {
        DB::beginTransaction();

        try {
            $subtotal = $cartItems->sum('total');
            $shippingCost = self::calculateShipping($data['delivery_method']);
            $total = $subtotal + $shippingCost;

            $shippingAddress = null;
            if (in_array($data['delivery_method'], ['courier', 'express'])) {
                $shippingAddress = $data['shipping_address'];
            }

            $order = self::create([
                'order_number' => self::generateOrderNumber(),
                'user_id' => auth()->id(),
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'shipping_address' => $shippingAddress,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'payment_method' => $data['payment_method'],
                'delivery_method' => $data['delivery_method'],
                'comment' => $data['comment'] ?? null
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'variation_id' => $item->variation_id,
                    'product_name' => $item->variation->product->name,
                    'variation_name' => $item->variation->name,
                    'sku' => $item->variation->sku,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total
                ]);

                $item->variation->decrement('stock', $item->quantity);
            }

            CartItem::clear();

            DB::commit();

            return ['success' => true, 'order' => $order];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Рассчитать стоимость доставки
     */
    private static function calculateShipping($method)
    {
        return match ($method) {
            'express' => 300,
            'courier' => 0,
            'pickup' => 0,
            default => 0,
        };
    }

    public function getDeliveryStatusNameAttribute(): string
    {
        return self::DELIVERY_STATUSES[$this->delivery_status] ?? $this->delivery_status;
    }

    public function getPaymentStatusNameAttribute(): string
    {
        return self::PAYMENT_STATUSES[$this->payment_status] ?? $this->payment_status;
    }

    public function getDeliveryStatusColorAttribute(): string
    {
        return match ($this->delivery_status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    public function getDeliveryStatusIconAttribute(): string
    {
        return match ($this->delivery_status) {
            'pending' => 'bi-clock',
            'processing' => 'bi-arrow-repeat',
            'shipped' => 'bi-truck',
            'delivered' => 'bi-check-circle',
            'cancelled' => 'bi-x-circle',
            default => 'bi-question-circle'
        };
    }

    /**
     * Получить все возможные статусы доставки для выпадающего списка
     */
    public static function getDeliveryStatuses(): array
    {
        return self::DELIVERY_STATUSES;
    }

    /**
     * Получить все возможные статусы оплаты для выпадающего списка
     */
    public static function getPaymentStatuses(): array
    {
        return self::PAYMENT_STATUSES;
    }

    public static function getRevenue($startDate, $endDate, $paidOnly = true)
    {
        $query = self::query();

        if ($paidOnly) {
            $query->where('payment_status', 'paid');
        }

        return $query->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
    }

    public static function getMonthlyRevenue()
    {
        return self::getRevenue(now()->startOfMonth(), now()->endOfMonth());
    }
}
