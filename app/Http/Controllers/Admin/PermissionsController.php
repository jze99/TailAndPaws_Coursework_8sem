<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Список прав
     */
    public function index()
    {
        $permissions = Permission::orderBy('group')->orderBy('name')->paginate(10);
        return view('admin.permissions.permissions', compact('permissions'));
    }

    /**
     * Сохранить новое право
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'slug' => 'required|string|max:255|unique:permissions',
            'group' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ], [
            'name.required' => 'Обязательно для заполнения',
            'name.unique' => 'Право с таким названием уже существует',
            'slug.required' => 'Обязательно для заполнения',
            'slug.unique' => 'Право с таким slug уже существует'
        ]);

        Permission::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'group' => $request->group,
            'description' => $request->description
        ]);

        return redirect()->route('admin.permissions')
            ->with('success', 'Право "' . $request->name . '" успешно создано');
    }

    /**
     * Форма редактирования
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Обновить право
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'slug' => 'required|string|max:255|unique:permissions,slug,' . $id,
            'group' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ], [
            'name.required' => 'Обязательно для заполнения',
            'name.unique' => 'Право с таким названием уже существует',
            'slug.required' => 'Обязательно для заполнения',
            'slug.unique' => 'Право с таким slug уже существует'
        ]);

        $permission->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'group' => $request->group,
            'description' => $request->description
        ]);

        return redirect()->route('admin.permissions')
            ->with('success', 'Право "' . $permission->name . '" успешно обновлено');
    }

    /**
     * Удалить право
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $rolesCount = $permission->roles()->count();

        $permissionName = $permission->name;
        $permission->delete();

        $message = 'Право "' . $permissionName . '" успешно удалено';
        if ($rolesCount > 0) {
            $message .= ' Право было удалено у ' . $rolesCount . ' ролей.';
        }

        return redirect()->route('admin.permissions')
            ->with('success', $message);
    }
}
