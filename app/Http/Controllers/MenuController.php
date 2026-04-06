<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Brand;
use App\Models\Product;

class MenuController extends Controller
{
    public function getMenuData()
    {
        $categories = Category::getTreeMenu();

        $footerCategories = Category::root()
            ->active()
            ->orderBy('sort_order')
            ->get();

        $contacts = Contact::getData();

        $popularBrands = Brand::active()->popular()->limit(8)->get();

        return [
            'categories' => $categories,
            'contacts' => $contacts,
            'popularBrands' => $popularBrands,
            'footerCategories' => $footerCategories,
        ];
    }

    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        // Проверка на минимальную длину
        if (mb_strlen($query) < 3) {
            return redirect()->back()->with('error', 'Для поиска введите минимум 3 символа');
        }

        // Поиск товаров
        $products = Product::with(['variations', 'brand', 'category'])
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('meta_keywords', 'like', "%{$query}%")
            ->active()
            ->paginate(20);

        // Поиск брендов
        $brands = Brand::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->active()
            ->limit(10)
            ->get();

        return view('search.results', compact('products', 'brands', 'query'));
    }

    /**
     * AJAX поиск для подсказок
     */
    public function searchAjax(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json([]);
        }

        // Поиск товаров
        $products = Product::with('variations')
            ->where('name', 'like', "%{$query}%")
            ->active()
            ->limit(5)
            ->get(['id', 'name', 'slug']);

        // Поиск брендов
        $brands = Brand::where('name', 'like', "%{$query}%")
            ->active()
            ->limit(3)
            ->get(['id', 'name', 'slug']);

        return response()->json([
            'products' => $products,
            'brands' => $brands
        ]);
    }
}
