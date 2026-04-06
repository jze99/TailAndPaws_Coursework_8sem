<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'parent_id',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function getFullSlugAttribute(): string
    {
        $slugs = [];
        $current = $this;

        while ($current) {
            $slugs[] = $current->slug;
            $current = $current->parent;
        }

        return implode('/', array_reverse($slugs));
    }

    public function getUrlAttribute(): string
    {
        return route('category.show', $this->full_slug);
    }

    public function getBreadcrumbsAttribute()
    {
        $breadcrumbs = [];
        $current = $this;

        while ($current) {
            array_unshift($breadcrumbs, [
                'name' => $current->name,
                'slug' => $current->slug,
                'url' => $current->url
            ]);
            $current = $current->parent;
        }

        return $breadcrumbs;
    }

    public function getPathAttribute()
    {
        $path = [];
        $current = $this;

        while ($current) {
            array_unshift($path, $current->slug);
            $current = $current->parent;
        }

        return implode('/', $path);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public static function getTreeMenu()
    {
        return self::with('descendants')->root()->active()->orderBy('sort_order')->get();
    }

    public static function findByPath($path)
    {
        $slugs = explode('/', trim($path, '/'));
        $category = null;

        foreach ($slugs as $slug) {
            if (!$category) {
                $category = self::where('slug', $slug)
                    ->whereNull('parent_id')
                    ->active()
                    ->first();
            } else {
                $category = $category->children()
                    ->where('slug', $slug)
                    ->active()
                    ->first();
            }

            if (!$category) {
                return null;
            }
        }

        return $category;
    }

    public static function getSelectTree($maxLevel = 1)
    {
        $categories = self::with('parent')->get();

        return $categories->map(function ($cat) {
            $cat->level = $cat->calculateLevel();
            return $cat;
        })->filter(function ($cat) use ($maxLevel) {
            return $cat->level < $maxLevel;
        });
    }

    public static function getFlatTree()
    {
        $categories = self::with('parent')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->get();

        return self::buildFlatTree($categories);
    }

    private static function buildFlatTree($categories, $parentId = null, $level = 0)
    {
        $result = collect();

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->level = $level;
                $result->push($category);

                $children = self::buildFlatTree($categories, $category->id, $level + 1);
                $result = $result->concat($children);
            }
        }

        return $result;
    }

    public function getLevelAttribute()
    {
        return $this->calculateLevel();
    }

    public function calculateLevel($level = 0)
    {
        if ($this->parent) {
            return $this->parent->calculateLevel($level + 1);
        }
        return $level;
    }

    public function isDescendantOf($ancestorId): bool
    {
        $current = $this;
        while ($current) {
            if ($current->id == $ancestorId) {
                return true;
            }
            $current = $current->parent;
        }
        return false;
    }

    public function getIconUrlAttribute(): string
    {
        if ($this->icon !== NULL) {
            $iconPath = 'assets/images/categories/icons/' . $this->icon;
            if (file_exists(public_path($iconPath))) {
                return asset($iconPath);
            }
        }

        return asset('assets/images/categories/icons/default.svg');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image !== NULL) {
            $imagePath = 'assets/images/categories/images/' . $this->image;
            if (file_exists(public_path($imagePath))) {
                return asset($imagePath);
            }
        }

        return asset('assets/images/categories/images/default.svg');
    }

    public function getAllCategoryIds(): array
    {
        $ids = [$this->id];

        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllCategoryIds());
        }

        return $ids;
    }

    // В модели Category
    public function productsWithChildren()
    {
        $categoryIds = $this->getAllCategoryIds();

        return Product::whereIn('category_id', $categoryIds);
    }
}
