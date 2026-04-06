<aside class="tw-bg-dark-green tw-text-light-gray">
    <div class="p-4">
        <a href="/" class="d-flex align-items-center gap-2 text-decoration-none mb-4">
            <img src="{{ asset('assets/images/logo/' . $menuContacts->logo) }}" alt="{{ $menuContacts->name }}" width="50" height="50">
            <span class="tw-text-light-gray fw-bold fs-4">Админ-панель</span>
        </a>

        {{-- Меню --}}
        <nav class="nav flex-column">
            {{-- Дашборд (доступен всем с admin_access) --}}
            @can('admin_access')
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link tw-text-light-gray {{ request()->is('admin/dashboard') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-speedometer2 me-2"></i>
                Панель управления
            </a>
            @endcan

            {{-- Заказы --}}
            @can('view_orders')
            <a href="{{ route('admin.orders') }}"
                class="nav-link tw-text-light-gray {{ request()->is('admin/orders*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-bag me-2"></i>
                Заказы
            </a>
            @endcan

            {{-- Товары --}}
            @can('view_products')
            <a href="/admin/products"
                class="nav-link tw-text-light-gray {{ request()->is('admin/products*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-box me-2"></i>
                Товары
            </a>
            @endcan

            {{-- Категории --}}
            @can('manage_categories')
            <a href="/admin/categories"
                class="nav-link tw-text-light-gray {{ request()->is('admin/categories*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-folder me-2"></i>
                Категории
            </a>
            @endcan

            {{-- Бренды --}}
            @can('manage_brands')
            <a href="{{ route('admin.brands') }}"
                class="nav-link tw-text-light-gray {{ request()->is('admin/brands*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-tag me-2"></i>
                Бренды
            </a>
            @endcan

            {{-- Пользователи --}}
            @can('view_users')
            <a href="/admin/users"
                class="nav-link tw-text-light-gray {{ request()->is('admin/users*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-people me-2"></i>
                Юзеры
            </a>
            @endcan

            @canany(['manage_roles', 'manage_permissions', 'edit_shop_settings'])
            <hr class="tw-border-light-gray my-3">
            @endcanany

            {{-- Роли --}}
            @can('manage_roles')
            <a href="{{ route('admin.roles') }}"
                class="nav-link tw-text-light-gray {{ request()->is('admin/roles*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-shield me-2"></i>
                Роли
            </a>
            @endcan

            {{-- Права --}}
            @can('manage_permissions')
            <a href="{{ route('admin.permissions') }}"
                class="nav-link tw-text-light-gray {{ request()->is('admin/permissions*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-key me-2"></i>
                Права
            </a>
            @endcan

            {{-- Настройки магазина --}}
            @can('edit_shop_settings')
            <a href="{{ route('admin.contacts.edit') }}"
                class="nav-link tw-text-light-gray {{ request()->is('admin/settings') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-gear me-2"></i>
                Настройки
            </a>
            @endcan

            {{-- Выход на сайт (для всех) --}}
            <hr class="tw-border-light-gray my-3">

            <a href="/"
                class="nav-link tw-text-light-gray rounded mb-1">
                <i class="bi bi-house me-2"></i>
                На сайт
            </a>
        </nav>
    </div>
</aside>