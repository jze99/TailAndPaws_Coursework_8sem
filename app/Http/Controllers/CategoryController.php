<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function showByPath(Request $request, $path)
    {
        $category = Category::findByPath($path);

        if (!$category) {
            abort(404);
        }

        $categoryIds = $category->getAllCategoryIds();

        $brands = Brand::whereHas('products', function ($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds)
                ->active();
        })
            ->active()
            ->orderBy('name')
            ->get();

        $priceRange = DB::table('products')
            ->join('product_variations', 'products.id', '=', 'product_variations.product_id')
            ->whereIn('products.category_id', $categoryIds)
            ->where('products.is_active', true)
            ->where('product_variations.is_active', true)
            ->selectRaw('MIN(product_variations.price) as min_price, MAX(product_variations.price) as max_price')
            ->first();

        $minPrice = $priceRange->min_price ?? 0;
        $maxPrice = $priceRange->max_price ?? 10000;

        $productsQuery = $category->productsWithChildren()
            ->with(['variations', 'brand'])
            ->active();

        if ($request->has('brands') && !empty($request->brands)) {
            $productsQuery->whereIn('brand_id', $request->brands);
        }

        if ($request->has('price-min') && $request->has('price-max')) {
            $min = (float) $request->get('price-min');
            $max = (float) $request->get('price-max');

            $productsQuery->whereHas('variations', function ($q) use ($min, $max) {
                $q->whereBetween('price', [$min, $max]);
            });
        }

        $products = $productsQuery->orderBy('created_at', 'desc')->paginate(20);

        $products->appends($request->all());

        $children = $category->children()->active()->get();

        return view('categories.show', compact('category', 'products', 'children', 'brands', 'minPrice', 'maxPrice'));
    }
}
