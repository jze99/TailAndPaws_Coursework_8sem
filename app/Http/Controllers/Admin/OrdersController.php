<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Список заказов
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Поиск по номеру заказа
        if ($request->filled('search')) {
            $query->where('order_number', 'like', "%{$request->search}%");
        }

        // Фильтр по статусу
        if ($request->filled('status')) {
            $query->where('delivery_status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.orders', compact('orders'));
    }

    /**
     * Детали заказа
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.variation.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Обновление статуса заказа
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'delivery_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'delivery_status' => $request->delivery_status,
            'payment_status' => $request->payment_status
        ]);

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Статус заказа обновлен');
    }
}
