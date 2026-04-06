<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Display all brands.
     */
    public function index()
    {
        $brands = Brand::active()
            ->withCount('products')
            ->orderBy('name')
            ->paginate(20);

        return view('brands.brands', compact('brands'));
    }

    /**
     * Display products by brand with filters.
     */
    public function show(Request $request, $slug)
    {
        $brand = Brand::where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Получаем ID категорий, в которых есть товары этого бренда
        $categoryIds = $brand->products()
            ->active()
            ->pluck('category_id')
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        // Загружаем категории с родителями для построения полного пути
        $categories = Category::with(['parent', 'parent.parent'])
            ->whereIn('id', $categoryIds)
            ->active()
            ->get();

        // Формируем полный путь для каждой категории
        $categoriesWithPath = $categories->map(function ($category) {
            $path = [];
            $current = $category;

            while ($current) {
                $path[] = $current->name;
                $current = $current->parent;
            }

            $category->full_path = implode(' / ', array_reverse($path));
            return $category;
        })->sortBy('full_path');

        // Диапазон цен
        $priceRange = DB::table('products')
            ->join('product_variations', 'products.id', '=', 'product_variations.product_id')
            ->where('products.brand_id', $brand->id)
            ->where('products.is_active', true)
            ->selectRaw('MIN(product_variations.price) as min_price, MAX(product_variations.price) as max_price')
            ->first();

        $minPrice = $priceRange->min_price ?? 0;
        $maxPrice = $priceRange->max_price ?? 10000;

        // Запрос на продукты с фильтрацией
        $productsQuery = Product::with(['variations', 'category'])
            ->where('brand_id', $brand->id)
            ->active();

        // Фильтрация по категориям
        if ($request->has('categories') && !empty($request->categories)) {
            $productsQuery->whereIn('category_id', $request->categories);
        }

        // Фильтрация по цене
        if ($request->has('price-min') && $request->has('price-max')) {
            $min = (float) $request->get('price-min');
            $max = (float) $request->get('price-max');

            $productsQuery->whereHas('variations', function ($q) use ($min, $max) {
                $q->whereBetween('price', [$min, $max]);
            });
        }

        // Сортировка
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        if ($sort === 'price') {
            $productsQuery->withMin('variations', 'price')
                ->orderBy('variations_min_price', $order);
        } elseif ($sort === 'name') {
            $productsQuery->orderBy('name', $order);
        } else {
            $productsQuery->orderBy($sort, $order);
        }

        $products = $productsQuery->paginate(20);
        $products->appends($request->all());

        return view('brands.show', compact('brand', 'products', 'categoriesWithPath', 'minPrice', 'maxPrice'));
    }
}
