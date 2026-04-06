<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', 'Хвостики и лапки')</title>
    <link rel="icon" href="{{ asset('assets/images/logo/' . $menuContacts->favicon) }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/nouislider.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
    @if (isset($style))
    <link rel="stylesheet" href="{{ asset('assets/css/' .  $style . '.css') }}">
    @endif
</head>

<body>
    @include('partials.menu.menu')

    <main class="mt-4 mb-4 mt-lg-5 mb-lg-5">
        @yield('content')
    </main>

    <footer class="tw-bg-dark-green pt-4 pb-4">
        <div class="container d-flex flex-column gap-5">
            <div class="row g-4 justify-content-center">
                {{-- О компании --}}
                <section class="footer-section col-12 col-lg-6 col-xl-4">
                    <h3 class="pb-2">О компании</h3>
                    <div class="footer-links">
                        <a class="footer-link" href="{{ route('about') }}">О нас</a>
                        <a class="footer-link" href="{{ route('contacts') }}">Контакты</a>
                        @auth
                        @can('admin_access')
                        <a class="footer-link" href="{{ route('admin.dashboard') }}">Админ-панель</a>
                        @endcan
                        @can('manage_cart')
                        <a class="footer-link" href="{{ route('cart.index') }}">Корзина</a>
                        @endcan
                        @can('cabinet_access')
                        <a class="footer-link" href="{{ route('profile.index') }}">Личный кабинет</a>
                        @endcan
                        @endauth
                    </div>
                </section>

                {{-- Категории (0 уровень) --}}
                <section class="footer-section col-12 col-lg-6 col-xl-4">
                    <h3 class="pb-2">Категории</h3>
                    <div class="footer-links">
                        @foreach($footerCategories as $category)
                        <a class="footer-link" href="{{ $category->url }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </section>

                {{-- Контакты --}}
                <section class="footer-section col-12 col-lg-6 col-xl-4 tw-text-light-gray">
                    <h3 class="pb-2">Связаться с нами</h3>
                    <p>Контактный номер телефона: {{ $menuContacts->phone }}</p>
                    <p class="mt-2">Адрес электронной почты: {{ $menuContacts->email }}</p>
                    <p class="mt-2">Адрес: {{ $menuContacts->address }}</p>
                    <p class="mt-2">Часы работы: {{ $menuContacts->work_hours }}</p>
                    <div class="social-media d-flex gap-3 align-items-center mt-3">
                        @if($menuContacts->telegram)
                        <a href="https://t.me/{{ $menuContacts->telegram }}" target="_blank" class="btn btn-orange p-0 action-btn">
                            <img src="{{ asset('assets/images/icons/social_media/telegram-svgrepo-com.svg') }}" alt="telegram" class="header-icon">
                        </a>
                        @endif
                        @if($menuContacts->vkontakte)
                        <a href="https://vk.com/{{ $menuContacts->vkontakte }}" target="_blank" class="btn btn-orange p-0 action-btn">
                            <img src="{{ asset('assets/images/icons/social_media/vk-svgrepo-com.svg') }}" alt="vk" class="header-icon">
                        </a>
                        @endif
                        @if($menuContacts->whatsapp)
                        <a href="https://wa.me/{{ $menuContacts->whatsapp }}" target="_blank" class="btn btn-orange p-0 action-btn">
                            <img src="{{ asset('assets/images/icons/social_media/whatsapp-svgrepo-com.svg') }}" alt="whatsapp" class="header-icon">
                        </a>
                        @endif
                    </div>
                </section>
            </div>
            <div class="d-flex justify-content-between gap-2">
                <p class="p-0 tw-text-light-gray">&copy; <span class="current-year"></span> {{ $menuContacts->name }}. Все права защищены.</p>
                <a href="{{ route('privacy-policy') }}" class="tw-text-light-gray text-decoration-underline"> Политика обработки персональных данных</a> 
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/current-year.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-cart.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-search.js') }}"></script>
    @yield('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth <= 991) {
                const catalogItem = document.querySelector('.dropdown-megamenu > .nav-link');
                const megamenu = document.querySelector('.megamenu');

                if (catalogItem && megamenu) {
                    catalogItem.addEventListener('click', function(e) {
                        e.preventDefault();
                        megamenu.style.display = megamenu.style.display === 'block' ? 'none' : 'block';
                    });
                }
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown-megamenu')) {
                    const megamenu = document.querySelector('.megamenu');
                    if (megamenu && window.innerWidth <= 991) {
                        megamenu.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>

</html>