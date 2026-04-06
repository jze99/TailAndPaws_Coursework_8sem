<nav class="navbar navbar-dark tw-bg-dark-green">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <img src="{{ asset('assets/images/logo/' . $menuContacts->logo) }}" width="35" height="35">
            Админ-панель
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="collapse" id="mobileMenu">
    <div class="tw-bg-dark-green p-3">
        <nav class="nav flex-column">
            @can('admin_access')
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.dashboard') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-speedometer2 me-2"></i> Панель управления
            </a>
            @endcan

            @can('view_orders')
            <a href=""
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.orders*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-bag me-2"></i> Заказы
            </a>
            @endcan

            @can('view_products')
            <a href=""
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.products*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-box me-2"></i> Товары
            </a>
            @endcan

            @can('manage_categories')
            <a href=""
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.categories*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-folder me-2"></i> Категории
            </a>
            @endcan

            @can('manage_brands')
            <a href="{{ route('admin.brands') }}"
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.brands*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-tag me-2"></i> Бренды
            </a>
            @endcan

            @can('view_users')
            <a href=""
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.users*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-people me-2"></i> Пользователи
            </a>
            @endcan

            <hr class="tw-border-light-gray my-2">

            @can('manage_roles')
            <a href=""
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.roles*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-shield me-2"></i> Роли
            </a>
            @endcan

            @can('manage_permissions')
            <a href=""
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.permissions*') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-key me-2"></i> Права
            </a>
            @endcan

            @can('edit_shop_settings')
            <a href=""
                class="nav-link tw-text-light-gray {{ request()->routeIs('admin.settings') ? 'tw-bg-orange' : '' }} rounded mb-1">
                <i class="bi bi-gear me-2"></i> Настройки
            </a>
            @endcan

            <hr class="tw-border-light-gray my-2">

            <a href="/" class="nav-link tw-text-light-gray rounded mb-1">
                <i class="bi bi-house me-2"></i> На сайт
            </a>

            <div class="mt-3 pt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-orange w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Выйти
                    </button>
                </form>
            </div>
        </nav>
    </div>
</div>