<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display user orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('orders.orders', compact('orders'));
    }

    /**
     * Display order details.
     */
    public function show(Order $order)
    {
        $user = Auth::user();
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('profile.order-show', compact('order', 'user'));
    }
}
