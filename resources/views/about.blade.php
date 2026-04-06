@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Главная</a>
            </li>
            <li class="breadcrumb-item active">О нас</li>
        </ol>
    </nav>

    {{-- Основной блок --}}
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center pt-3">
            <p class="fs-4">
                TailAndPaws — это команда профессионалов, объединенных любовью к животным.
            </p>
        </div>
    </div>

    {{-- Наши преимущества --}}
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="text-center p-4">
                <i class="bi bi-truck fs-1 tw-text-dark-green"></i>
                <h4 class="mt-3">Быстрая доставка</h4>
                <p class="text-muted">Доставляем заказы по всей России</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="text-center p-4">
                <i class="bi bi-shield-check fs-1 tw-text-dark-green"></i>
                <h4 class="mt-3">Гарантия качества</h4>
                <p class="text-muted">Только сертифицированные товары</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="text-center p-4">
                <i class="bi bi-headset fs-1 tw-text-dark-green"></i>
                <h4 class="mt-3">Поддержка 24/7</h4>
                <p class="text-muted">Всегда готовы помочь</p>
            </div>
        </div>
    </div>

    {{-- История --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="tw-bg-orange tw-text-light-gray p-5 rounded-0">
                <div class="row">
                    <div class="col-md-10 mx-auto d-flex flex-column gap-4">

                        <p><strong>Миссия компании</strong> — предоставлять владельцам домашних животных доступ к качественным, безопасным и проверенным товарам по доступным ценам.</p>

                        <p><strong>Что мы предлагаем:</strong></p>
                        <ul>
                            <li>--- Широкий ассортимент кормов, амуниции, игрушек и аксессуаров</li>
                            <li>--- Продукцию только от проверенных производителей</li>
                            <li>--- Регулярное обновление ассортимента</li>
                            <li>--- Доставку по всей России</li>
                            <li>--- Консультации специалистов по выбору товаров</li>
                        </ul>

                        <p><strong>Наши приоритеты:</strong></p>
                        <ul>
                            <li>--- Качество каждого товара на полке</li>
                            <li>--- Честные цены без скрытых наценок</li>
                            <li>--- Быстрая обработка и отправка заказов</li>
                            <li>--- Открытость и прозрачность перед клиентами</li>
                        </ul>

                        <p class="mb-0 mt-3 fst-italic text-center">TailAndPaws — забота, которой доверяют.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Наши партнеры (топ бренды) --}}
    @if($topBrands->count())
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center fs-4 mb-4">Наши партнеры</h2>
            <p class="text-center text-muted mb-5">Мы сотрудничаем с лучшими производителями товаров для животных</p>
            <div class="row g-4 justify-content-center">
                @foreach($topBrands as $brand)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="d-flex flex-column align-items-center p-3">
                        @if($brand->logo)
                        <img src="{{ asset('assets/images/brands/' . $brand->logo) }}"
                            alt="{{ $brand->name }}"
                            class="img-fluid"
                            style="max-height: 80px; object-fit: contain;">
                        @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="bi bi-building fs-1 text-secondary"></i>
                        </div>
                        @endif
                        <p class="mt-2 mb-0 fw-semibold">{{ $brand->name }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center fs-4 mb-4">Где нас найти</h2>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="mb-3">Наши контакты</h4>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt tw-text-dark-green me-2"></i>
                            <strong>Адрес:</strong><br>
                            {{ $menuContacts->address ?? 'г. Челябинск, ул. Дружбы, д. 15' }}
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone tw-text-dark-green me-2"></i>
                            <strong>Телефон:</strong><br>
                            <a href="tel:{{ $menuContacts->phone ?? '+7(985)-070-56-33' }}" class="text-decoration-none">
                                {{ $menuContacts->phone ?? '+7(985)-070-56-33' }}
                            </a>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope tw-text-dark-green me-2"></i>
                            <strong>Email:</strong><br>
                            <a href="mailto:{{ $menuContacts->email ?? 'tailandpaws_info@gmail.com' }}" class="text-decoration-none">
                                {{ $menuContacts->email ?? 'tailandpaws_info@gmail.com' }}
                            </a>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-clock tw-text-dark-green me-2"></i>
                            <strong>Режим работы:</strong><br>
                            {{ $menuContacts->work_hours ?? 'Пн-Пт: 10:00 - 18:00, Сб-Вс: выходной' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-0">
                    <div style="position:relative;overflow:hidden; height: 100%; min-height: 350px;">
                        <iframe
                            src="https://yandex.com/map-widget/v1/?ll=61.445115%2C55.142641&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg1NjAyNDI0ORJA0KDQvtGB0YHQuNGPLCDQp9C10LvRj9Cx0LjQvdGB0LosINGD0LvQuNGG0LAg0JPQsNCz0LDRgNC40L3QsCwgNyIKDUDHdUIVYpJcQg%2C%2C&z=17.99"
                            width="100%"
                            height="350"
                            frameborder="0"
                            allowfullscreen="true"
                            style="border:0;">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection