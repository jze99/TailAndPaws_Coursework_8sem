<header class="tw-bg-dark-green pt-3 pb-3">
    <div class="container">
        <nav class="navbar navbar-expand-xl navbar-dark">
            <div class="container-fluid px-0 align-items-center">
                <a class="navbar-brand d-flex align-items-center gap-2 me-4 flex-shrink-0" href="/">
                    <img src="{{ asset('assets/images/logo/' . $menuContacts->logo) }}" alt="{{ $menuContacts->name }}" width="70" height="70">
                    <h3 class="fs-2 tw-text-light-gray p-0 m-0 text-uppercase">{{ $menuContacts->name }}</h3>
                </a>

                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerHeader" aria-controls="navbarTogglerHeader" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse w-100" id="navbarTogglerHeader">
                    <div class="d-xl-flex w-100 align-items-center gap-3">
                        <ul class="navbar-nav flex-wrap flex-grow-1 mb-2 mb-xl-0 header-main-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">Главная</a>
                            </li>

                            <li class="nav-item dropdown-megamenu">
                                <a class="nav-link d-flex align-items-center justify-content-center {{ request()->routeIs('category.show') ? 'active' : '' }}"
                                    href=""
                                    id="catalogDropdown" role="button">
                                    Каталог
                                    <span class="dropdown-icon ms-1">
                                        <img src="{{ asset('assets/images/icons/dropdown-arrow-svgrepo-com.svg') }}" alt="dropdown">
                                    </span>
                                </a>

                                @include('partials.menu.catalog-megamenu')
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">О нас</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакты</a>
                            </li>
                        </ul>

                        <div class="header-right d-flex align-items-center justify-content-between gap-2">
                            <form class="header-search d-flex position-relative" role="search" action="{{ route('search') }}" method="GET" onsubmit="return validateSearch()">
                                <input id="input_search" class="form-control" type="search"
                                    name="q" placeholder="Поиск" value="{{ request('q') }}" required>
                                <button class="btn btn-orange p-0 action-btn" type="submit">
                                    <img src="{{ asset('assets/images/icons/search-svgrepo-com.svg') }}" alt="Найти" class="header-icon">
                                </button>
                            </form>

                            @guest
                            <a href="{{ route('login') }}" class="btn btn-orange p-0 action-btn" title="Войти">
                                <img src="{{ asset('assets/images/icons/enter-svgrepo-com.svg') }}" alt="Войти" class="header-icon">
                            </a>
                            @endguest

                            @auth
                            @can('manage_cart')
                            <a href="{{ route('cart.index') }}" class="btn btn-orange p-0 action-btn position-relative" title="Корзина">
                                <img src="{{ asset('assets/images/icons/cart-svgrepo-com.svg') }}" alt="Корзина" class="header-icon">
                                <span class="cart-count position-absolute translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                    {{ \App\Models\CartItem::getCount() }}
                                </span>
                            </a>
                            @endcan

                            <div class="d-none d-xl-block">
                                <div class="dropdown auth-dropdown">
                                    <button class="btn btn-orange p-0 action-btn" type="button">
                                        <img src="{{ asset('assets/images/icons/menu-svgrepo-com.svg') }}" alt="Меню" class="header-icon">
                                    </button>

                                    <div class="auth-dropdown-menu">
                                        @can('cabinet_access')
                                        <a href="" class="btn btn-orange p-0 action-btn" title="Личный кабинет">
                                            <img src="{{ asset('assets/images/icons/user-svgrepo-com.svg') }}" alt="Кабинет" class="header-icon">
                                        </a>
                                        @endcan

                                        @can('admin_access')
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-orange p-0 action-btn" title="Панель управления">
                                            <img src="{{ asset('assets/images/icons/settings-svgrepo-com.svg') }}" alt="Админка" class="header-icon">
                                        </a>
                                        @endcan

                                        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Вы действительно хотите выйти?');">
                                            @csrf
                                            <button type="submit" class="btn btn-orange p-0 action-btn" title="Выйти">
                                                <img src="{{ asset('assets/images/icons/logout-svgrepo-com.svg') }}" alt="Выйти" class="header-icon">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="d-xl-none user-mobile-menu">
                                @can('cabinet_access')
                                <a href="" class="btn btn-orange p-0 action-btn" title="Личный кабинет">
                                    <img src="{{ asset('assets/images/icons/user-svgrepo-com.svg') }}" alt="Кабинет" class="header-icon">
                                </a>
                                @endcan

                                @can('admin_access')
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-orange p-0 action-btn" title="Панель управления">
                                    <img src="{{ asset('assets/images/icons/settings-svgrepo-com.svg') }}" alt="Админка" class="header-icon">
                                </a>
                                @endcan

                                <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Вы действительно хотите выйти?');">
                                    @csrf
                                    <button type="submit" class="btn btn-orange p-0 action-btn" title="Выйти">
                                        <img src="{{ asset('assets/images/icons/logout-svgrepo-com.svg') }}" alt="Выйти" class="header-icon">
                                    </button>
                                </form>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>