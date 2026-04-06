<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::getFlatTree();

        $allCategories = Category::getSelectTree(2);

        return view('admin.categories.categories', compact('categories', 'allCategories'));
    }

    public function moveUp($id)
    {
        $category = Category::findOrFail($id);

        $previous = Category::where('parent_id', $category->parent_id)
            ->where('sort_order', '<', $category->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        if ($previous) {
            $temp = $category->sort_order;
            $category->sort_order = $previous->sort_order;
            $previous->sort_order = $temp;

            $category->save();
            $previous->save();
        }

        return redirect()->route('admin.categories')->with('success', 'Порядок категорий обновлен');
    }

    public function moveDown($id)
    {
        $category = Category::findOrFail($id);

        $next = Category::where('parent_id', $category->parent_id)
            ->where('sort_order', '>', $category->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        if ($next) {
            $temp = $category->sort_order;
            $category->sort_order = $next->sort_order;
            $next->sort_order = $temp;

            $category->save();
            $next->save();
        }

        return redirect()->route('admin.categories')->with('success', 'Порядок категорий обновлен');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Название категории обязательно',
            'name.max' => 'Название не может быть длиннее 255 символов',
            'icon.image' => 'Загрузите изображение (jpg, png, svg)',
            'icon.max' => 'Изображение не должно превышать 2 МБ',
            'image.image' => 'Загрузите изображение (jpg, png, svg)',
            'image.max' => 'Изображение не должно превышать 2 МБ',
            'parent_id.exists' => 'Выбранная родительская категория не существует',
        ]);

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = Str::slug($request->name) . '_icon.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('assets/images/categories/icons'), $iconName);
            $validated['icon'] = $iconName;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '_image.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/categories/images'), $imageName);
            $validated['image'] = $imageName;
        }

        $validated['slug'] = Str::slug($request->name);

        if (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . uniqid();
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = Category::where('parent_id', $request->parent_id)->max('sort_order') + 10;

        Category::create($validated);

        return redirect()->route('admin.categories')
            ->with('success', 'Категория "' . $request->name . '" успешно создана');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $allCategories = Category::with('parent')
            ->get()
            ->map(function ($cat) use ($category) {
                $cat->level = $cat->calculateLevel();
                $cat->disabled = $cat->id == $category->id || $cat->isDescendantOf($category->id);
                return $cat;
            })
            ->filter(function ($cat) {
                return $cat->level < 2;
            });

        return view('admin.categories.edit', compact('category', 'allCategories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'is_active' => 'nullable|boolean',
            'remove_icon' => 'nullable|boolean',
            'remove_image' => 'nullable|boolean',
        ], [
            'name.required' => 'Название категории обязательно',
            'name.max' => 'Название не может быть длиннее 255 символов',
            'icon.image' => 'Загрузите изображение (jpg, png, svg)',
            'icon.max' => 'Изображение не должно превышать 2 МБ',
            'image.image' => 'Загрузите изображение (jpg, png, svg)',
            'image.max' => 'Изображение не должно превышать 2 МБ',
            'parent_id.exists' => 'Выбранная родительская категория не существует',
        ]);

        $category->name = $validated['name'];
        $category->description = $validated['description'];
        $category->parent_id = $validated['parent_id'];
        $category->is_active = $request->has('is_active');

        if ($request->hasFile('icon')) {
            if ($category->icon && file_exists(public_path('assets/images/categories/icons/' . $category->icon))) {
                unlink(public_path('assets/images/categories/icons/' . $category->icon));
            }

            $icon = $request->file('icon');
            $iconName = Str::slug($request->name) . '_icon.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('assets/images/categories/icons'), $iconName);
            $category->icon = $iconName;
        }

        if ($request->has('remove_icon') && $request->remove_icon == 1) {
            if ($category->icon && file_exists(public_path('assets/images/categories/icons/' . $category->icon))) {
                unlink(public_path('assets/images/categories/icons/' . $category->icon));
            }
            $category->icon = null;
        }

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('assets/images/categories/images/' . $category->image))) {
                unlink(public_path('assets/images/categories/images/' . $category->image));
            }

            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '_image.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/categories/images'), $imageName);
            $category->image = $imageName;
        }

        if ($request->has('remove_image') && $request->remove_image == 1) {
            if ($category->image && file_exists(public_path('assets/images/categories/images/' . $category->image))) {
                unlink(public_path('assets/images/categories/images/' . $category->image));
            }
            $category->image = null;
        }

        $category->save();

        return redirect()->route('admin.categories')
            ->with('success', 'Категория "' . $category->name . '" успешно обновлена');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $categoryName = $category->name;

        if ($category->icon && file_exists(public_path('assets/images/categories/icons/' . $category->icon))) {
            unlink(public_path('assets/images/categories/icons/' . $category->icon));
        }

        if ($category->image && file_exists(public_path('assets/images/categories/images/' . $category->image))) {
            unlink(public_path('assets/images/categories/images/' . $category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories')
            ->with('success', 'Категория "' . $categoryName . '" успешно удалена');
    }
}
