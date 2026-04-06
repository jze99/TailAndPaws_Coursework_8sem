<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductAttribute;
use App\Models\VariationAttribute;
use App\Models\VariationImage;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'variations.images'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.products.products', compact('products'));
    }

    public function create()
    {
        $categories = Category::getFlatTree();
        $brands = Brand::active()->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',

            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',

            'attributes' => 'nullable|array',
            'attributes.*.key' => 'nullable|string',
            'attributes.*.value' => 'nullable|string',

            'variations' => 'required|array|min:1',
            'variations.*.name' => 'required|string|max:255',
            'variations.*.sku' => 'required|string|max:100|unique:product_variations,sku',
            'variations.*.price' => 'required|numeric|min:0',
            'variations.*.old_price' => 'nullable|numeric|min:0',
            'variations.*.stock' => 'required|integer|min:0',
            'variations.*.is_default' => 'nullable|boolean',
            'variations.*.attributes' => 'nullable|array',
            'variations.*.attributes.flavor' => 'nullable|string|max:100',
            'variations.*.attributes.color' => 'nullable|string|max:100',
            'variations.*.attributes.size' => 'nullable|string|max:50',
            'variations.*.attributes.weight' => 'nullable|numeric|min:0',

            'variations.*.images' => 'nullable|array',
            'variations.*.images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Название товара обязательно',
            'category_id.required' => 'Выберите категорию',
            'variations.required' => 'Добавьте хотя бы одну вариацию',
            'variations.*.name.required' => 'Название вариации обязательно',
            'variations.*.sku.required' => 'Артикул обязателен',
            'variations.*.sku.unique' => 'Артикул "{value}" уже существует',
            'variations.*.price.required' => 'Цена обязательна',
            'variations.*.stock.required' => 'Количество обязательно',
            'variations.*.images.*.image' => 'Файл должен быть изображением',
            'variations.*.images.*.mimes' => 'Допустимые форматы: jpg, jpeg, png, webp',
            'variations.*.images.*.max' => 'Размер изображения не должен превышать 2 МБ',
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($request->name);
            $baseSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $product = Product::create([
                'name' => $validated['name'],
                'slug' => $slug,
                'category_id' => $validated['category_id'],
                'brand_id' => $validated['brand_id'] ?? null,
                'description' => $validated['description'] ?? null,
                'is_active' => $request->boolean('is_active'),
                'meta_title' => $validated['meta_title'] ?? null,
                'meta_description' => $validated['meta_description'] ?? null,
                'meta_keywords' => $validated['meta_keywords'] ?? null,
            ]);

            // Сохраняем атрибуты товара
            if (!empty($validated['attributes'])) {
                foreach ($validated['attributes'] as $attr) {
                    if (!empty($attr['key']) && !empty($attr['value'])) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'key' => $attr['key'],
                            'value' => $attr['value'],
                        ]);
                    }
                }
            }

            // Создаем вариации
            foreach ($validated['variations'] as $index => $variationData) {
                $variation = ProductVariation::create([
                    'product_id' => $product->id,
                    'name' => $variationData['name'],
                    'sku' => $variationData['sku'],
                    'price' => $variationData['price'],
                    'old_price' => $variationData['old_price'] ?? null,
                    'stock' => $variationData['stock'],
                    'is_default' => $variationData['is_default'] ?? ($index == 0),
                    'is_active' => true,
                ]);

                // Сохраняем атрибуты вариации
                if (!empty($variationData['attributes'])) {
                    foreach ($variationData['attributes'] as $key => $value) {
                        if (!empty($value) || $value === 0 || $value === '0') {
                            VariationAttribute::create([
                                'variation_id' => $variation->id,
                                'key' => $key,
                                'value' => $value,
                            ]);
                        }
                    }
                }

                // Сохраняем изображения
                if ($request->hasFile("variations.{$index}.images")) {
                    $files = $request->file("variations.{$index}.images");
                    $validFiles = array_filter($files, function ($file) {
                        return $file !== null && $file->isValid();
                    });

                    if (!empty($validFiles)) {
                        $this->saveVariationImages($validFiles, $product->slug, $variation->id);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.create')
                ->with('success', 'Товар "' . $product->name . '" успешно создан');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product create error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ошибка при создании товара: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::with(['variations.attributes', 'variations.images', 'attributes', 'brand', 'category'])->findOrFail($id);

        $categories = Category::getFlatTree();
        
        $brands = Brand::active()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',

            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',

            'attributes' => 'nullable|array',
            'attributes.*.key' => 'nullable|string',
            'attributes.*.value' => 'nullable|string',

            'variations' => 'required|array|min:1',
            'variations.*.id' => 'nullable|exists:product_variations,id',
            'variations.*.name' => 'required|string|max:255',
            'variations.*.sku' => 'required|string|max:100',
            'variations.*.price' => 'required|numeric|min:0',
            'variations.*.old_price' => 'nullable|numeric|min:0',
            'variations.*.stock' => 'required|integer|min:0',
            'variations.*.is_default' => 'nullable|boolean',
            'variations.*.attributes' => 'nullable|array',
            'variations.*.attributes.flavor' => 'nullable|string|max:100',
            'variations.*.attributes.color' => 'nullable|string|max:100',
            'variations.*.attributes.size' => 'nullable|string|max:50',
            'variations.*.attributes.weight' => 'nullable|numeric|min:0',

            'variations.*.images' => 'nullable|array',
            'variations.*.images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variations.*.removed_images' => 'nullable|array',
            'variations.*.removed_images.*' => 'nullable|string',
            'variations.*.existing_images' => 'nullable|array',
            'variations.*.existing_images.*' => 'nullable|string',
        ], [
            // Основные поля
            'name.required' => 'Название товара обязательно',
            'name.string' => 'Название товара должно быть строкой',
            'name.max' => 'Название товара не может превышать 255 символов',

            'category_id.required' => 'Выберите категорию',
            'category_id.exists' => 'Выбранная категория не существует',

            'brand_id.exists' => 'Выбранный бренд не существует',

            'meta_title.max' => 'Meta Title не может превышать 255 символов',

            // Вариации
            'variations.required' => 'Добавьте хотя бы одну вариацию',
            'variations.array' => 'Некорректный формат вариаций',
            'variations.min' => 'Добавьте хотя бы одну вариацию',

            'variations.*.id.exists' => 'Вариация с ID :input не найдена',

            'variations.*.name.required' => 'Название вариации обязательно',
            'variations.*.name.string' => 'Название вариации должно быть строкой',
            'variations.*.name.max' => 'Название вариации не может превышать 255 символов',

            'variations.*.sku.required' => 'Артикул (SKU) обязателен',
            'variations.*.sku.string' => 'Артикул должен быть строкой',
            'variations.*.sku.max' => 'Артикул не может превышать 100 символов',

            'variations.*.price.required' => 'Цена обязательна',
            'variations.*.price.numeric' => 'Цена должна быть числом',
            'variations.*.price.min' => 'Цена не может быть отрицательной',

            'variations.*.old_price.numeric' => 'Старая цена должна быть числом',
            'variations.*.old_price.min' => 'Старая цена не может быть отрицательной',

            'variations.*.stock.required' => 'Количество обязательно',
            'variations.*.stock.integer' => 'Количество должно быть целым числом',
            'variations.*.stock.min' => 'Количество не может быть отрицательным',

            'variations.*.is_default.boolean' => 'Поле "Основная вариация" должно быть true или false',

            'variations.*.attributes.array' => 'Некорректный формат атрибутов вариации',

            'variations.*.attributes.flavor.string' => 'Вкус должен быть строкой',
            'variations.*.attributes.flavor.max' => 'Вкус не может превышать 100 символов',

            'variations.*.attributes.color.string' => 'Цвет должен быть строкой',
            'variations.*.attributes.color.max' => 'Цвет не может превышать 100 символов',

            'variations.*.attributes.size.string' => 'Размер должен быть строкой',
            'variations.*.attributes.size.max' => 'Размер не может превышать 50 символов',

            'variations.*.attributes.weight.numeric' => 'Вес должен быть числом',
            'variations.*.attributes.weight.min' => 'Вес не может быть отрицательным',

            // Изображения
            'variations.*.images.array' => 'Некорректный формат изображений',

            'variations.*.images.*.image' => 'Файл должен быть изображением',
            'variations.*.images.*.mimes' => 'Допустимые форматы изображений: jpg, jpeg, png, webp',
            'variations.*.images.*.max' => 'Размер изображения не должен превышать 2 МБ',

            'variations.*.removed_images.array' => 'Некорректный формат списка удаляемых изображений',
            'variations.*.removed_images.*.string' => 'Путь к удаляемому изображению должен быть строкой',

            'variations.*.existing_images.array' => 'Некорректный формат списка существующих изображений',
            'variations.*.existing_images.*.string' => 'Путь к существующему изображению должен быть строкой',

            // Атрибуты товара
            'attributes.array' => 'Некорректный формат характеристик',
            'attributes.*.key.string' => 'Название характеристики должно быть строкой',
            'attributes.*.value.string' => 'Значение характеристики должно быть строкой',
        ]);

        DB::beginTransaction();

        try {
            // Обновляем slug если изменилось название
            $newSlug = Str::slug($validated['name']);
            $oldSlug = $product->slug;

            if ($oldSlug != $newSlug) {
                $slug = $newSlug;
                $counter = 1;
                while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $newSlug . '-' . $counter;
                    $counter++;
                }
                $product->slug = $slug;
                $this->renameProductFolder($oldSlug, $slug, $product);
            }

            // Обновляем товар
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'brand_id' => $validated['brand_id'],
                'category_id' => $validated['category_id'],
                'is_active' => $request->boolean('is_active'),
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
                'meta_keywords' => $validated['meta_keywords'],
            ]);

            // Обновляем атрибуты товара
            ProductAttribute::where('product_id', $product->id)->delete();
            if (!empty($validated['attributes'])) {
                foreach ($validated['attributes'] as $attr) {
                    if (!empty($attr['key']) && !empty($attr['value'])) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'key' => $attr['key'],
                            'value' => $attr['value'],
                        ]);
                    }
                }
            }

            $existingVariationIds = [];

            foreach ($validated['variations'] as $index => $variationData) {
                if (isset($variationData['id']) && $variationData['id']) {
                    $variation = ProductVariation::find($variationData['id']);

                    if ($variation && $variation->product_id == $product->id) {
                        $variation->update([
                            'name' => $variationData['name'],
                            'sku' => $variationData['sku'],
                            'price' => $variationData['price'],
                            'old_price' => $variationData['old_price'] ?? null,
                            'stock' => $variationData['stock'],
                            'is_default' => $variationData['is_default'] ?? false,
                        ]);

                        // Обновляем атрибуты вариации
                        VariationAttribute::where('variation_id', $variation->id)->delete();
                        if (!empty($variationData['attributes'])) {
                            foreach ($variationData['attributes'] as $key => $value) {
                                if (!empty($value) || $value === 0 || $value === '0') {
                                    VariationAttribute::create([
                                        'variation_id' => $variation->id,
                                        'key' => $key,
                                        'value' => $value,
                                    ]);
                                }
                            }
                        }

                        // ========== ОБРАБОТКА ИЗОБРАЖЕНИЙ ==========
                        // 1. Удаляем отмеченные изображения
                        if (!empty($variationData['removed_images']) && is_array($variationData['removed_images'])) {
                            foreach ($variationData['removed_images'] as $imagePath) {
                                $image = VariationImage::where('variation_id', $variation->id)
                                    ->where('path', $imagePath)
                                    ->first();
                                if ($image) {
                                    $fullPath = public_path($imagePath);
                                    if (file_exists($fullPath) && is_file($fullPath)) {
                                        @unlink($fullPath);
                                    }
                                    $image->delete();
                                }
                            }
                        }

                        // 2. Обновляем порядок существующих изображений
                        if (!empty($variationData['existing_images']) && is_array($variationData['existing_images'])) {
                            foreach ($variationData['existing_images'] as $sortOrder => $imagePath) {
                                $image = VariationImage::where('variation_id', $variation->id)
                                    ->where('path', $imagePath)
                                    ->first();
                                if ($image) {
                                    $image->sort_order = $sortOrder;
                                    $image->save();
                                }
                            }
                        }

                        // 3. Сохраняем новые изображения
                        if ($request->hasFile("variations.{$index}.images")) {
                            $files = $request->file("variations.{$index}.images");
                            $validFiles = array_filter($files, function ($file) {
                                return $file !== null && $file->isValid();
                            });

                            if (!empty($validFiles)) {
                                $this->saveVariationImages($validFiles, $product->slug, $variation->id);
                            }
                        }

                        $existingVariationIds[] = $variation->id;
                    }
                } else {
                    // Создаем новую вариацию
                    $variation = ProductVariation::create([
                        'product_id' => $product->id,
                        'name' => $variationData['name'],
                        'sku' => $variationData['sku'],
                        'price' => $variationData['price'],
                        'old_price' => $variationData['old_price'] ?? null,
                        'stock' => $variationData['stock'],
                        'is_default' => $variationData['is_default'] ?? false,
                        'is_active' => true,
                    ]);

                    // Сохраняем атрибуты
                    if (!empty($variationData['attributes'])) {
                        foreach ($variationData['attributes'] as $key => $value) {
                            if (!empty($value) || $value === 0 || $value === '0') {
                                VariationAttribute::create([
                                    'variation_id' => $variation->id,
                                    'key' => $key,
                                    'value' => $value,
                                ]);
                            }
                        }
                    }

                    // Сохраняем изображения
                    if ($request->hasFile("variations.{$index}.images")) {
                        $files = $request->file("variations.{$index}.images");
                        $validFiles = array_filter($files, function ($file) {
                            return $file !== null && $file->isValid();
                        });

                        if (!empty($validFiles)) {
                            $this->saveVariationImages($validFiles, $product->slug, $variation->id);
                        }
                    }

                    $existingVariationIds[] = $variation->id;
                }
            }

            // Удаляем вариации, которых нет в форме
            $variationsToDelete = ProductVariation::where('product_id', $product->id)
                ->whereNotIn('id', $existingVariationIds)
                ->get();

            foreach ($variationsToDelete as $variation) {
                // Удаляем изображения из БД и файловой системы
                $images = VariationImage::where('variation_id', $variation->id)->get();
                foreach ($images as $image) {
                    $fullPath = public_path($image->path);
                    if (file_exists($fullPath) && is_file($fullPath)) {
                        @unlink($fullPath);
                    }
                    $image->delete();
                }

                // Удаляем атрибуты
                VariationAttribute::where('variation_id', $variation->id)->delete();

                // Удаляем папку
                $folderPath = public_path('assets/images/products/' . $product->slug . '/variation_' . $variation->id);
                if (file_exists($folderPath) && is_dir($folderPath)) {
                    $this->deleteDirectory($folderPath);
                }

                $variation->delete();
            }

            DB::commit();

            return redirect()->route('admin.products')
                ->with('success', 'Товар "' . $product->name . '" успешно обновлен');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ошибка при обновлении товара: ' . $e->getMessage());
        }
    }

    private function saveVariationImages($images, $productSlug, $variationId)
    {
        $folder = public_path('assets/images/products/' . $productSlug . '/variation_' . $variationId);

        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        // Получаем текущий максимальный sort_order
        $maxSortOrder = VariationImage::where('variation_id', $variationId)->max('sort_order');
        $nextIndex = ($maxSortOrder !== null) ? $maxSortOrder + 1 : 0;

        foreach ($images as $index => $image) {
            if ($image && $image->isValid()) {
                $extension = $image->getClientOriginalExtension();
                $filename = ($nextIndex + $index) . '.' . $extension;
                $destinationPath = $folder . '/' . $filename;

                $image->move($folder, $filename);

                if (file_exists($destinationPath)) {
                    VariationImage::create([
                        'variation_id' => $variationId,
                        'path' => 'assets/images/products/' . $productSlug . '/variation_' . $variationId . '/' . $filename,
                        'sort_order' => $nextIndex + $index,
                    ]);
                }
            }
        }
    }

    private function renameProductFolder($oldSlug, $newSlug, $product)
    {
        $oldFolder = public_path('assets/images/products/' . $oldSlug);
        $newFolder = public_path('assets/images/products/' . $newSlug);

        if (file_exists($oldFolder) && is_dir($oldFolder)) {
            if (file_exists($newFolder)) {
                $this->mergeDirectories($oldFolder, $newFolder);
                $this->deleteDirectory($oldFolder);
            } else {
                rename($oldFolder, $newFolder);
            }

            // Обновляем пути в БД
            $variations = ProductVariation::where('product_id', $product->id)->get();
            foreach ($variations as $variation) {
                $images = VariationImage::where('variation_id', $variation->id)->get();
                foreach ($images as $image) {
                    $image->path = str_replace('assets/images/products/' . $oldSlug, 'assets/images/products/' . $newSlug, $image->path);
                    $image->save();
                }
            }
        }
    }

    private function mergeDirectories($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        $files = scandir($source);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;

            $sourcePath = $source . '/' . $file;
            $destPath = $destination . '/' . $file;

            if (is_dir($sourcePath)) {
                $this->mergeDirectories($sourcePath, $destPath);
                rmdir($sourcePath);
            } else {
                copy($sourcePath, $destPath);
                unlink($sourcePath);
            }
        }
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    public function checkSku(Request $request)
    {
        $request->validate([
            'sku' => 'required|string',
            'variation_id' => 'nullable|exists:product_variations,id',
            'product_id' => 'nullable|exists:products,id'
        ]);

        $sku = $request->sku;
        $variationId = $request->variation_id;
        $productId = $request->product_id;

        $isUnique = ProductVariation::isSkuUnique($sku, $variationId, $productId);

        return response()->json([
            'unique' => $isUnique,
            'message' => $isUnique ? null : 'Артикул "' . $sku . '" уже используется'
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $productName = $product->name;

        foreach ($product->variations as $variation) {
            $images = VariationImage::where('variation_id', $variation->id)->get();
            foreach ($images as $image) {
                $fullPath = public_path($image->path);
                if (file_exists($fullPath) && is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }
            $folderPath = public_path('assets/images/products/' . $product->slug . '/variation_' . $variation->id);
            if (file_exists($folderPath) && is_dir($folderPath)) {
                $this->deleteDirectory($folderPath);
            }
        }

        $productFolder = public_path('assets/images/products/' . $product->slug);
        if (file_exists($productFolder) && is_dir($productFolder)) {
            $this->deleteDirectory($productFolder);
        }

        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Товар "' . $productName . '" успешно удален');
    }

    public function duplicate($id)
    {
        DB::beginTransaction();

        try {
            $original = Product::with(['variations.attributes', 'variations.images'])->findOrFail($id);

            $newProduct = $original->replicate();
            $newProduct->name = $original->name . ' (копия)';
            $newProduct->slug = Str::slug($newProduct->name) . '-' . uniqid();
            $newProduct->created_at = now();
            $newProduct->updated_at = now();
            $newProduct->save();

            // Копируем атрибуты товара
            foreach ($original->attributes as $attr) {
                ProductAttribute::create([
                    'product_id' => $newProduct->id,
                    'key' => $attr->key,
                    'value' => $attr->value,
                ]);
            }

            // Копируем вариации
            foreach ($original->variations as $variation) {
                $newVariation = $variation->replicate();
                $newVariation->product_id = $newProduct->id;
                $newVariation->sku = $variation->sku . '-copy-' . uniqid();
                $newVariation->created_at = now();
                $newVariation->updated_at = now();
                $newVariation->save();

                // Копируем атрибуты вариации
                foreach ($variation->attributes as $attr) {
                    VariationAttribute::create([
                        'variation_id' => $newVariation->id,
                        'key' => $attr->key,
                        'value' => $attr->value,
                    ]);
                }

                // Копируем изображения
                $newFolder = public_path('assets/images/products/' . $newProduct->slug . '/variation_' . $newVariation->id);
                if (!file_exists($newFolder)) {
                    mkdir($newFolder, 0755, true);
                }

                foreach ($variation->images as $image) {
                    $oldPath = public_path($image->path);
                    $filename = basename($image->path);
                    $newPath = $newFolder . '/' . $filename;

                    if (file_exists($oldPath)) {
                        copy($oldPath, $newPath);
                        VariationImage::create([
                            'variation_id' => $newVariation->id,
                            'path' => 'assets/images/products/' . $newProduct->slug . '/variation_' . $newVariation->id . '/' . $filename,
                            'sort_order' => $image->sort_order,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products')
                ->with('success', 'Товар "' . $original->name . '" успешно скопирован. Новая версия: "' . $newProduct->name . '"');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product duplicate error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ошибка при копировании товара: ' . $e->getMessage());
        }
    }
}
