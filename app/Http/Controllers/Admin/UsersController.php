<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $users->appends($request->all());

        return view('admin.users.users', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ], [
            'name.required' => 'Обязательно для заполнения',
            'name.max' => 'Не более 255 символов',
            'email.required' => 'Обязательно для заполнения',
            'email.email' => 'Введите корректный email',
            'email.max' => 'Не более 255 символов',
            'email.unique' => 'Этот email уже занят',
            'phone.max' => 'Не более 20 символов',
            'password.required' => 'Обязательно для заполнения',
            'password.min' => 'Минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'role_id.required' => 'Обязательно для заполнения'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Пользователь "' . $user->name . '" успешно создан');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ], [
            'name.required' => 'Обязательно для заполнения',
            'name.max' => 'Не более 255 символов',
            'email.required' => 'Обязательно для заполнения',
            'email.email' => 'Введите корректный email',
            'email.max' => 'Не более 255 символов',
            'email.unique' => 'Этот email уже занят',
            'phone.max' => 'Не более 20 символов',
            'password.min' => 'Минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'role_id.required' => 'Обязательно для заполнения'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'Пользователь "' . $user->name . '" успешно обновлен');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'Нельзя удалить самого себя');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'Пользователь "' . $userName . '" успешно удален');
    }
}
