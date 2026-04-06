<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Личный кабинет - главная
     */
    public function index()
    {
        $user = Auth::user();
        $activeOrders = Order::where('user_id', $user->id)
            ->whereNotIn('delivery_status', ['delivered', 'cancelled'])
            ->orderBy('created_at', 'desc')
            ->get();

        $archiveOrders = Order::where('user_id', $user->id)
            ->whereIn('delivery_status', ['delivered', 'cancelled'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.profile', compact('user', 'activeOrders', 'archiveOrders'));
    }

    /**
     * Редактирование профиля
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Обновление профиля
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Обязательно для заполнения',
            'email.required' => 'Обязательно для заполнения',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Этот email уже занят',
            'current_password.required_with' => 'Введите текущий пароль',
            'current_password.current_password' => 'Неверный текущий пароль',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Профиль успешно обновлен');
    }

    /**
     * Детали заказа
     */
    public function orderShow($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.variation.product')
            ->findOrFail($id);
        $user = Auth::user();

        return view('profile.order-show', compact('order', 'user'));
    }
}
