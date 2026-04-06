<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OrdersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('index');

//Макет
Route::get('/maket', function () {
    return view('maket');
})->name('maket');

// Страница "О нас"
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Страница "Контакты"
Route::get('/contacts', [HomeController::class, 'contacts'])->name('contacts');

// Поиск
Route::get('/search', [MenuController::class, 'search'])->name('search');
Route::get('/search/ajax', [MenuController::class, 'searchAjax'])->name('search.ajax');

// Аутентификация
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Политика конфиденциальности
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
// Категории
Route::get('/catalog/{path}', [CategoryController::class, 'showByPath'])
    ->where('path', '.*')
    ->name('category.show');

// Продукты
Route::get('/product/{slug}', [ProductsController::class, 'show'])->name('product.show');
Route::get('/api/variation/{variationId}/images', [ProductsController::class, 'getVariationImages']);

// Бренды (с префиксом /brands)
Route::prefix('brands')->name('brands.')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('index');      // brands.index
    Route::get('/{slug}', [BrandController::class, 'show'])->name('show');  // brands.show
});

Route::middleware(['auth', 'permission:	checkout'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
});

Route::middleware(['auth', 'permission:checkout'])
    ->prefix('checkout')
    ->name('checkout.')
    ->group(function () {
        Route::get('/', [CartController::class, 'checkout'])->name('index');
        Route::post('/process', [CartController::class, 'processOrder'])->name('process');
    });

Route::middleware(['auth', 'permission:manage_cart'])
    ->prefix('cart')
    ->name('cart.')
    ->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });


// Админка
Route::middleware(['auth', 'permission:admin_access'])->prefix('admin')->name('admin.')->group(function () {

    // Дашборд
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== БРЕНДЫ (требуют manage_brands) =====
    Route::middleware(['permission:manage_brands'])->group(function () {
        Route::get('/brands', [BrandsController::class, 'index'])->name('brands');
        Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');
        Route::get('/brands/{id}/edit', [BrandsController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{id}', [BrandsController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{id}', [BrandsController::class, 'destroy'])->name('brands.destroy');
    });

    // ===== КАТЕГОРИИ (требуют manage_categories) =====
    Route::middleware(['permission:manage_categories'])->group(function () {
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
        Route::patch('/categories/{id}/move-up', [CategoriesController::class, 'moveUp'])->name('categories.move-up');
        Route::patch('/categories/{id}/move-down', [CategoriesController::class, 'moveDown'])->name('categories.move-down');
    });

    // ===== ПРОДУКТЫ (требуют manage_products) =====
    Route::middleware(['permission:manage_products'])->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/{id}/duplicate', [ProductController::class, 'duplicate'])->name('products.duplicate');
        Route::post('/products/check-sku', [ProductController::class, 'checkSku'])->name('products.check-sku');
    });

    // ===== ЗАКАЗЫ В АДМИНКЕ (требуют view_orders и edit_orders) =====
    Route::get('/orders', [OrdersController::class, 'index'])
        ->middleware('permission:view_orders')
        ->name('orders');

    Route::get('/orders/{order}', [OrdersController::class, 'show'])
        ->middleware('permission:view_orders')
        ->name('orders.show');

    Route::put('/orders/{order}/status', [OrdersController::class, 'updateStatus'])
        ->middleware('permission:edit_orders')
        ->name('orders.update-status');

    // ===== РОЛИ (требуют manage_roles) =====
    Route::middleware(['permission:manage_roles'])->group(function () {
        Route::get('/roles', [RolesController::class, 'index'])->name('roles');
        Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RolesController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RolesController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
    });

    // ===== ПРАВА ДОСТУПА (требуют manage_permissions) =====
    Route::middleware(['permission:manage_permissions'])->group(function () {
        Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions');
        Route::post('/permissions', [PermissionsController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{id}/edit', [PermissionsController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{id}', [PermissionsController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{id}', [PermissionsController::class, 'destroy'])->name('permissions.destroy');
    });

    // ===== ПОЛЬЗОВАТЕЛИ (требуют manage_users) =====
    Route::middleware(['permission:manage_users'])->group(function () {
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    });

    // ===== КОНТАКТЫ / НАСТРОЙКИ (требуют edit_shop_settings) =====
    Route::middleware(['permission:edit_shop_settings'])->group(function () {
        Route::get('/contacts', [ContactController::class, 'edit'])->name('contacts.edit');
        Route::put('/contacts', [ContactController::class, 'update'])->name('contacts.update');
    });
});

// Личный кабинет
Route::middleware(['auth', 'permission:cabinet_access'])
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/orders/{id}', [ProfileController::class, 'orderShow'])->name('order.show');
    });
