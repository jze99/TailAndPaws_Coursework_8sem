@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Главная</a>
            </li>
            <li class="breadcrumb-item active">Контакты</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-5 mb-4 pt-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="mb-4">Контактная информация</h3>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-geo-alt fs-4 tw-text-dark-green me-3"></i>
                            <div>
                                <strong>Адрес</strong><br>
                                {{ $menuContacts->address ?? 'г. Челябинск, ул. Дружбы, д. 15' }}
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-telephone fs-4 tw-text-dark-green me-3"></i>
                            <div>
                                <strong>Телефон</strong><br>
                                <a href="tel:{{ $menuContacts->phone ?? '+7(985)-070-56-33' }}" class="text-decoration-none">
                                    {{ $menuContacts->phone ?? '+7(985)-070-56-33' }}
                                </a>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-envelope fs-4 tw-text-dark-green me-3"></i>
                            <div>
                                <strong>Email</strong><br>
                                <a href="mailto:{{ $menuContacts->email ?? 'tailandpaws_info@gmail.com' }}" class="text-decoration-none">
                                    {{ $menuContacts->email ?? 'tailandpaws_info@gmail.com' }}
                                </a>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock fs-4 tw-text-dark-green me-3"></i>
                            <div>
                                <strong>Режим работы</strong><br>
                                {{ $menuContacts->work_hours ?? 'Пн-Пт: 10:00 - 18:00, Сб-Вс: выходной' }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-3">
                        <p class="mb-2"><strong>Социальные сети:</strong></p>
                        <div class="d-flex gap-3">
                            <a href="{{ $menuContacts->telegram }}" class="btn btn-orange p-0 action-btn">
                                <img src="{{ asset('assets/images/icons/social_media/telegram-svgrepo-com.svg') }}" alt="telegram" class="header-icon">
                            </a>
                            <a href="{{ $menuContacts->vk }}" class="btn btn-orange p-0 action-btn">
                                <img src="{{ asset('assets/images/icons/social_media/whatsapp-svgrepo-com.svg') }}" alt="whatsapp" class="header-icon">
                            </a>
                            <a href="{{ $menuContacts->vk }}" class="btn btn-orange p-0 action-btn">
                                <img src="{{ asset('assets/images/icons/social_media/vk-svgrepo-com.svg') }}" alt="vk" class="header-icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-0">
                    <iframe
                        src="https://yandex.com/map-widget/v1/?ll=61.445115%2C55.142641&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg1NjAyNDI0ORJA0KDQvtGB0YHQuNGPLCDQp9C10LvRj9Cx0LjQvdGB0LosINGD0LvQuNGG0LAg0JPQsNCz0LDRgNC40L3QsCwgNyIKDUDHdUIVYpJcQg%2C%2C&z=17.99"
                        width="100%"
                        height="400"
                        frameborder="0"
                        allowfullscreen="true"
                        style="border:0;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="mailto:{{ $menuContacts->email ?? 'tailandpaws_info@gmail.com' }}" class="btn-dark-green px-5 py-3">
            Написать нам
        </a>
    </div>
</div>
@endsection