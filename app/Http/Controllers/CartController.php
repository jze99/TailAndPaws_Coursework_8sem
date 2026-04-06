<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\ProductVariation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Отобразить корзину
     */
    public function index()
    {
        $cartItems = CartItem::getCartQuery()->get();
        $total = $cartItems->sum('total');

        return view('cart.show', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'variation_id' => 'required|exists:product_variations,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $variation = ProductVariation::with('product')->find($request->variation_id);

        if (!$variation) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Товар не найден'], 404);
            }
            return back()->with('error', 'Товар не найден');
        }

        if ($variation->stock < $request->quantity) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Недостаточно товара на складе'], 422);
            }
            return back()->with('error', 'Недостаточно товара на складе');
        }

        $cartItem = CartItem::findByVariation($request->variation_id);

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($variation->stock < $newQuantity) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Недостаточно товара на складе'], 422);
                }
                return back()->with('error', 'Недостаточно товара на складе');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => session()->getId(),
                'variation_id' => $request->variation_id,
                'quantity' => $request->quantity,
                'price' => $variation->price
            ]);
        }

        $cartCount = CartItem::getCount();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен в корзину',
                'cart_count' => $cartCount
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину');
    }


    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cartItem = CartItem::find($id);

        if (!$cartItem) {
            return response()->json(['error' => 'Товар не найден'], 404);
        }

        $variation = $cartItem->variation;

        if ($variation->stock < $request->quantity) {
            return response()->json(['error' => 'Недостаточно товара на складе'], 422);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        $cartItems = CartItem::getCartQuery()->get();
        $cartTotal = $cartItems->sum('total');
        $totalItems = $cartItems->sum('quantity');

        return response()->json([
            'success' => true,
            'total' => $cartItem->total,
            'cart_total' => $cartTotal,
            'total_items' => $totalItems,
            'max_stock' => $variation->stock
        ]);
    }

    public function remove($id)
    {
        $cartItem = CartItem::findCartItem($id);

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
        }

        return redirect()->route('cart.index')->with('error', 'Товар не найден');
    }

    public function clear()
    {
        CartItem::clear();
        return redirect()->route('cart.index')->with('success', 'Корзина очищена');
    }

    public function checkout()
    {
        $cartItems = CartItem::getCartQuery()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $total = $cartItems->sum('total');

        return view('cart.checkout', compact('cartItems', 'total'));
    }

    public function processOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required_if:delivery_method,courier,express|max:1000',
            'delivery_method' => 'required|in:courier,pickup,express',
            'payment_method' => 'required|in:cash,card,online'
        ],  [
            'customer_name.required' => 'Поле обязательно для заполнения',
            'customer_email.required' => 'Поле  обязательно для заполнения',
            'customer_email.email' => 'Введите корректный адрес электронной почты',
            'customer_phone.required' => 'Поле  обязательно для заполнения',
            'shipping_address.required_if' => 'Адрес доставки обязателен для выбранного способа доставки',
            'delivery_method.required' => 'Выберите способ доставки',
            'payment_method.required' => 'Выберите способ оплаты'
        ]);


        $cartItems = CartItem::getCartQuery()->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Корзина пуста');
        }

        $order = Order::createFromCart($request->all(), $cartItems);

        if ($order['success']) {
            return redirect()->route('orders.show', $order['order'])
                ->with('success', 'Заказ оформлен! Номер заказа: ' . $order['order']->order_number);
        }

        return back()->with('error', $order['message']);
    }
}
