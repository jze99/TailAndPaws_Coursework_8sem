<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function show($slug)
    {
        $product = Product::with([
            'category',
            'category.parent',
            'brand',
            'variations',
            'variations.images',
            'attributes'
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $defaultVariation = $product->default_variation;

        return view('products.show', compact('product', 'defaultVariation'));
    }

    public function getVariationImages($variationId)
    {
        $images = ProductVariation::getImagesDataById($variationId);

        return response()->json([
            'success' => true,
            'images' => $images
        ]);
    }
}
