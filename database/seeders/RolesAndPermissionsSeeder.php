<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\String\s;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $this->cleanTables();
        $this->createPermissions();
        $this->createRoles();
        $this->assignPermissionsToRoles();
    }

    private function cleanTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function createPermissions()
    {
        $permissions = [

            // ========== ЛИЧНЫЙ КАБИНЕТ ==========
            [
                'name' => 'Доступ в личный кабинет',
                'slug' => 'cabinet_access',
                'group' => 'cabinet',
                'description' => 'Возможность входить в личный кабинет и просматривать свои данные'
            ],

            // ========== ЗАКАЗЫ ==========
            [
                'name' => 'Просматривать заказы',
                'slug' => 'view_orders',
                'group' => 'orders',
                'description' => 'Просмотр списка заказов'
            ],
            [
                'name' => 'Редактировать заказы',
                'slug' => 'edit_orders',
                'group' => 'orders',
                'description' => 'Редактирование заказов (статус, удаление, подтверждение)'
            ],
            [
                'name' => 'Оформлять заказы',
                'slug' => 'checkout',
                'group' => 'orders',
                'description' => 'Оформление заказов на сайте'
            ],

            // ========== КОРЗИНА ==========
            [
                'name' => 'Управлять корзиной',
                'slug' => 'manage_cart',
                'group' => 'cart',
                'description' => 'Добавление/удаление товаров из корзины'
            ],

            // ========== ТОВАРЫ ==========
            [
                'name' => 'Добавлять товары',
                'slug' => 'create_products',
                'group' => 'products',
                'description' => 'Создание новых товаров'
            ],
            [
                'name' => 'Редактировать товары',
                'slug' => 'edit_products',
                'group' => 'products',
                'description' => 'Редактирование товаров'
            ],
            [
                'name' => 'Управлять количеством товара',
                'slug' => 'manage_stock',
                'group' => 'products',
                'description' => 'Изменение остатков товаров на складе'
            ],

            // ========== ПОЛЬЗОВАТЕЛИ ==========
            [
                'name' => 'Просматривать пользователей',
                'slug' => 'view_users',
                'group' => 'users',
                'description' => 'Просмотр списка пользователей'
            ],
            [
                'name' => 'Создавать пользователей',
                'slug' => 'create_users',
                'group' => 'users',
                'description' => 'Создание новых пользователей'
            ],

            // ========== РОЛИ И ПРАВА ==========
            [
                'name' => 'Управлять ролями',
                'slug' => 'manage_roles',
                'group' => 'rbac',
                'description' => 'Создание/редактирование ролей'
            ],
            [
                'name' => 'Управлять правами',
                'slug' => 'manage_permissions',
                'group' => 'rbac',
                'description' => 'Создание/редактирование прав доступа'
            ],

            // ========== МАГАЗИН ==========
            [
                'name' => 'Редактировать данные магазина',
                'slug' => 'edit_shop_settings',
                'group' => 'shop',
                'description' => 'Изменение настроек магазина'
            ],

            // ========== ДОСТУП В АДМИНКУ ==========
            [
                'name' => 'Доступ в админ-панель',
                'slug' => 'admin_access',
                'group' => 'admin',
                'description' => 'Возможность входить в административную панель'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
            $this->command->info("✓ Создано право: {$permission['name']}");
        }
    }

    private function createRoles()
    {
        $roles = [
            [
                'name' => 'Супер администратор',
                'slug' => 'super_admin',
                'description' => 'Полный доступ ко всем функциям системы (обходит все проверки прав)'
            ],
            [
                'name' => 'Администратор магазина',
                'slug' => 'shop_admin',
                'description' => 'Полное управление магазином, товарами и заказами'
            ],
            [
                'name' => 'Менеджер по товарам',
                'slug' => 'product_manager',
                'description' => 'Управление каталогом товаров'
            ],
            [
                'name' => 'Менеджер по заказам',
                'slug' => 'order_manager',
                'description' => 'Обработка заказов'
            ],
            [
                'name' => 'Кладовщик',
                'slug' => 'warehouse_manager',
                'description' => 'Управление остатками товаров'
            ],
            [
                'name' => 'Зарегистрированный пользователь',
                'slug' => 'registered_user',
                'description' => 'Обычный пользователь сайта'
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
            $this->command->info("✓ Создана роль: {$roleData['name']}");
        }
    }

    private function assignPermissionsToRoles()
    {
        // ============================================
        // АДМИНИСТРАТОР МАГАЗИНА
        // ============================================

        $shopAdmin = Role::where('slug', 'shop_admin')->first();
        $shopAdmin->permissions()->sync(
            Permission::whereIn('slug', [
                'admin_access',
                'cabinet_access',
                'view_orders',
                'edit_orders',
                'checkout',
                'manage_cart',
                'create_products',
                'edit_products',
                'manage_stock',
                'view_users',
                'create_users',
                'manage_roles',
                'manage_permissions',
                'edit_shop_settings',
            ])->pluck('id')
        );
        $this->command->info('✓ Назначены права для Администратора магазина');

        // ============================================
        // МЕНЕДЖЕР ПО ТОВАРАМ
        // ============================================

        $productManager = Role::where('slug', 'product_manager')->first();
        $productManager->permissions()->sync(
            Permission::whereIn('slug', [
                'admin_access',
                'cabinet_access',
                'create_products',
                'edit_products',
                'view_orders',
            ])->pluck('id')
        );
        $this->command->info('✓ Назначены права для Менеджера по товарам');

        // ============================================
        // МЕНЕДЖЕР ПО ЗАКАЗАМ
        // ============================================
        $orderManager = Role::where('slug', 'order_manager')->first();
        $orderManager->permissions()->sync(
            Permission::whereIn('slug', [
                'admin_access',
                'cabinet_access',
                'view_orders',
                'edit_orders',
                'checkout',
                'view_users',
            ])->pluck('id')
        );
        $this->command->info('✓ Назначены права для Менеджера по заказам');

        // ============================================
        // КЛАДОВЩИК
        // ============================================
        $warehouseManager = Role::where('slug', 'warehouse_manager')->first();
        $warehouseManager->permissions()->sync(
            Permission::whereIn('slug', [
                'admin_access',
                'cabinet_access',
                'manage_stock',
                'view_orders',
            ])->pluck('id')
        );
        $this->command->info('✓ Назначены права для Кладовщика');

        // ============================================
        // ЗАРЕГИСТРИРОВАННЫЙ ПОЛЬЗОВАТЕЛЬ
        // ============================================
        $registeredUser = Role::where('slug', 'registered_user')->first();
        $registeredUser->permissions()->sync(
            Permission::whereIn('slug', [
                'cabinet_access',
                'manage_cart',
                'checkout',
            ])->pluck('id')
        );
        $this->command->info('✓ Назначены права для Зарегистрированного пользователя');
    }
}
