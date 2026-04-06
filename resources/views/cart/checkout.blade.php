@extends('layouts.app')

@section('title', 'Оформление заказа')

@php $style = 'checkout'; @endphp

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h2 mb-4">Оформление заказа</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf

                        {{-- Контактные данные --}}
                        <h5 class="mb-3">Контактные данные</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label">Ваше имя <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    name="customer_name"
                                    value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                                    required>
                                @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                    class="form-control @error('customer_email') is-invalid @enderror"
                                    name="customer_email"
                                    value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                    required>
                                @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Телефон <span class="text-danger">*</span></label>
                                <input type="tel"
                                    class="form-control @error('customer_phone') is-invalid @enderror"
                                    name="customer_phone"
                                    value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                                    required>
                                @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Способ доставки --}}
                        <h5 class="mb-3">Способ доставки</h5>
                        <div class="row g-3 mb-4 bg-light">
                            <div class="col-12">
                                <div class="delivery-options">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="delivery_method"
                                            id="delivery_courier" value="courier" checked>
                                        <label class="form-check-label" for="delivery_courier">
                                            <strong>Курьером</strong> — бесплатно
                                            <small class="text-muted d-block">Доставка по городу в течение 1-2 дней</small>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="delivery_method"
                                            id="delivery_pickup" value="pickup">
                                        <label class="form-check-label" for="delivery_pickup">
                                            <strong>Самовывоз</strong> — бесплатно
                                            <small class="text-muted d-block">Заберите заказ из нашего магазина</small>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="delivery_method"
                                            id="delivery_express" value="express">
                                        <label class="form-check-label" for="delivery_express">
                                            <strong>Экспресс-доставка</strong> — 300 ₽
                                            <small class="text-muted d-block">Доставка в течение 1-2 часов</small>
                                        </label>
                                    </div>
                                </div>
                                @error('delivery_method')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Адрес доставки (показывается только для курьера и экспресса) --}}
                        <div id="address-block" style="display: none;">
                            <h5 class="mb-3">Адрес доставки</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-12">
                                    <label class="form-label">Адрес <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                        name="shipping_address"
                                        rows="3"
                                        placeholder="Город, улица, дом, квартира">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Способ оплаты --}}
                        <h5 class="mb-3">Способ оплаты</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="payment-options">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment_cash" value="cash" checked>
                                        <label class="form-check-label" for="payment_cash">
                                            <strong>Наличными при получении</strong>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment_card" value="card">
                                        <label class="form-check-label" for="payment_card">
                                            <strong>Картой при получении</strong>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment_online" value="online">
                                        <label class="form-check-label" for="payment_online">
                                            <strong>Онлайн-оплата</strong>
                                            <small class="text-muted d-block">Картой на сайте, Яндекс.Деньги и др.</small>
                                        </label>
                                    </div>
                                </div>
                                @error('payment_method')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Комментарий --}}
                        <h5 class="mb-3">Комментарий к заказу</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <textarea class="form-control" name="comment" rows="3"
                                    placeholder="Если есть особые пожелания, напишите их здесь...">{{ old('comment') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-dark-green flex-grow-1 py-3" id="submit-btn">
                                Оформить заказ
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn-outline-mint py-3 px-4 text-decoration-none">
                                Назад
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Информация о заказе --}}
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Ваш заказ</h5>

                    <div class="order-items mb-3">
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <span class="fw-semibold">{{ $item->variation->product->name }}</span>
                                @if($item->variation->name)
                                <br><small class="text-muted">{{ $item->variation->name }}</small>
                                @endif
                                <br><small class="text-muted">{{ $item->quantity }} шт.</small>
                            </div>
                            <div class="text-end">
                                <span>{{ number_format($item->total, 0, '.', ' ') }} ₽</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="order-total">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Товары ({{ $cartItems->sum('quantity') }} шт.)</span>
                            <span id="order-subtotal">{{ number_format($total, 0, '.', ' ') }} ₽</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Доставка</span>
                            <span id="order-shipping">200 ₽</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Итого к оплате:</strong>
                            <strong class="fs-5 text-success" id="order-total">{{ number_format($total + 200, 0, '.', ' ') }} ₽</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
        const addressBlock = document.getElementById('address-block');
        const shippingAddress = document.querySelector('textarea[name="shipping_address"]');
        const orderShipping = document.getElementById('order-shipping');
        const orderTotal = document.getElementById('order-total');
        const orderSubtotal = document.getElementById('order-subtotal');

        const subtotal = parseInt(orderSubtotal.textContent.replace(/[^0-9]/g, '')) || 0;

        function updateShippingCost() {
            let shippingCost = 0;
            let selectedDelivery = document.querySelector('input[name="delivery_method"]:checked');

            if (selectedDelivery) {
                switch (selectedDelivery.value) {
                    case 'courier':
                        shippingCost = 0;
                        addressBlock.style.display = 'block';
                        break;
                    case 'express':
                        shippingCost = 300;
                        addressBlock.style.display = 'block';
                        break;
                    case 'pickup':
                        shippingCost = 0;
                        addressBlock.style.display = 'none';
                        break;
                }
            }

            if (orderShipping) orderShipping.textContent = shippingCost + ' ₽';
            if (orderTotal) orderTotal.textContent = (subtotal + shippingCost).toLocaleString() + ' ₽';
        }

        deliveryRadios.forEach(radio => {
            radio.addEventListener('change', updateShippingCost);
        });

        // Инициализация
        updateShippingCost();

        // Блокировка кнопки при отправке
        const form = document.getElementById('checkout-form');
        const submitBtn = document.getElementById('submit-btn');

        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Оформление...';
            });
        }
    });
</script>
@endsection