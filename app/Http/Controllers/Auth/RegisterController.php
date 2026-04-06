<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'save_checkbox' => 'accepted'
        ], [
            'name.required' => 'Обязательно введите Ваше имя',
            'email.required' => 'Обязательно введите адрес электронной почты',
            'phone.required' => 'Обязательно введите Ваш номер телефона',
            'email.email' => 'Введите корректный адрес электронной почты',
            'email.unique' => 'Пользователь с таким адресом электронной почты уже существует',
            'password.required' => 'Поле пароль обязательно для заполнения',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'save_checkbox.accepted' => 'Необходимо согласие на обработку персональных данных'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $defaultRole = Role::where('slug', 'registered_user')->first();
        if ($defaultRole) {
            $user->role()->attach($defaultRole->id);
        }

        auth()->login($user);

        return redirect()->intended('/')
            ->with('success', 'Регистрация прошла успешно!');
    }
}
