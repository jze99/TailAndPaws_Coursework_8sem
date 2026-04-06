<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(15);

        return view('admin.roles.roles', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ], [
            'name.required' => 'Обязательно для заполнения',
            'name.max' => 'Не более 255 символов',
            'slug.required' => 'Обязательно для заполнения',
            'slug.max' => 'Не более 255 символов',
            'slug.unique' => 'Такой slug уже существует',
            'permissions.*.exists' => 'Право не найдено'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()->route('admin.roles')
            ->with('success', 'Роль "' . $role->name . '" успешно создана');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,' . $id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('admin.roles')
            ->with('success', 'Роль "' . $role->name . '" успешно обновлена');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $usersCount = User::where('role_id', $role->id)->count();

        if ($usersCount > 0) {
            return redirect()->route('admin.roles')
                ->with('error', 'Нельзя удалить роль, у которой есть пользователи');
        }

        $roleName = $role->name;
        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles')
            ->with('success', 'Роль "' . $roleName . '" успешно удалена');
    }
}
