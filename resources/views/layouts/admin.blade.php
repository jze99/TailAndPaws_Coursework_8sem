<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($product))
    <meta name="product-id" content="{{ $product->id }}">
    @endif
    <title>@yield('title', 'Админ-панель')</title>
    <link rel="icon" href="{{ asset('assets/images/logo/' . $menuContacts->favicon) }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
</head>

<body>
    <div class="p-0 h-100">
        <div class="row g-0 h-100">
            <div class="d-none d-lg-block col-lg-3 col-xl-2">
                @include('admin.partials.sidebar')
            </div>

            <div class="col-12 col-lg-9 col-xl-10">
                <div class="d-block d-lg-none">
                    @include('admin.partials.mobile-nav')
                </div>

                <main class="p-4 h-100" style="background-color: #f8f9fa; min-height: 100vh;">
                    @include('admin.partials.header')
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
    @yield('script')
</body>

</html>