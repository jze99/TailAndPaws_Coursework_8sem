<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

use function Avifinfo\read;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->paginate(5);
        return view('admin.brands.brands', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Название бренда обязательно',
            'name.unique' => 'Бренд с таким названием уже существует',
            'name.max' => 'Название не может быть длиннее 255 символов',
            'logo.image' => 'Загрузите изображение (jpg, png, svg)',
            'logo.max' => 'Изображение не должно превышать 2 МБ',
            'website.url' => 'Введите корректный URL сайта',
            'website.max' => 'URL сайта не может быть длиннее 255 символов',
            'country.max' => 'Название страны не может быть длиннее 100 символов',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = Str::slug($request->name) . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/images/brands'), $logoName);
            $validated['logo'] = $logoName;
        }

        $validated['slug'] = Str::slug($request->name);

        $validated['is_active'] = $request->has('is_active');

        Brand::create($validated);

        return redirect()->route('admin.brands')
            ->with('success', 'Бренд "' . $request->name . '" успешно создан');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Название бренда обязательно',
            'name.max' => 'Название не может быть длиннее 255 символов',
            'logo.image' => 'Загрузите изображение (jpg, png, svg)',
            'logo.mimes' => 'Изображение должно быть в форматах: jpg, jpeg, png, svg',
            'logo.max' => 'Изображение не должно превышать 2 МБ',
            'website.url' => 'Введите корректный URL сайта',
            'website.max' => 'URL сайта не может быть длиннее 255 символов',
            'country.max' => 'Название страны не может быть длиннее 100 символов',
        ]);

        $brand->name = $validated['name'];
        $brand->description = $validated['description'];
        $brand->website = $validated['website'];
        $brand->country = $validated['country'];
        $brand->is_active = $request->has('is_active');

        if ($request->hasFile('logo')) {
            if ($brand->logo && file_exists(public_path('assets/images/brands/' . $brand->logo))) {
                unlink(public_path('assets/images/brands/' . $brand->logo));
            }

            $logo = $request->file('logo');
            $logoName = Str::slug($request->name) . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/images/brands'), $logoName);
            $brand->logo = $logoName;
        }

        $brand->save();

        return redirect()->route('admin.brands')
            ->with('success', 'Бренд "' . $brand->name . '" успешно обновлен');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $brandName = $brand->name;

        if ($brand->logo && file_exists(public_path('assets/images/brands/' . $brand->logo))) {
            unlink(public_path('assets/images/brands/' . $brand->logo));
        }

        $brand->delete();

        return redirect()->route('admin.brands')->with('success', 'Бренд "' . $brandName . '" успешно удален');
    }
}
