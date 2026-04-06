<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductAttribute;
use App\Models\VariationAttribute;
use App\Models\VariationImage;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        $discountedProducts = ProductVariation::with(['product', 'images'])
            ->discounted()
            ->inStock()
            ->active()
            ->orderByRaw('(old_price - price) / old_price * 100 DESC')
            ->limit(8)
            ->get();

        $categories = Category::active()->root()->orderBy('sort_order')->get();

        $dryCatFood = Product::getForCarousel(21, 12);

        $dryDogFood = Product::getForCarousel(3, 12);

        return view('index', compact('discountedProducts', 'categories', 'dryCatFood', 'dryDogFood'));
    }

    public function about()
    {

        $topBrands = Brand::active()->popular()->limit(5)->get();

        return view('about', compact('topBrands'));
    }

    public function contacts()
    {
        return view('contacts');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }
}
