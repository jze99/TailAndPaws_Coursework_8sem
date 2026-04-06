@extends('layouts.app')

@section('title', 'Корзина')

@php $style = 'cart'; @endphp

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h2 mb-4">Корзина</h1>
        </div>
    </div>

    @if($cartItems->count())
    <div class="row">
        {{-- Список товаров --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    @foreach($cartItems as $item)
                    <div class="cart-item p-3 border-bottom" data-id="{{ $item->id }}">
                        <div class="row align-items-center">
                            {{-- Изображение --}}
                            <div class="col-3 col-md-2">
                                <a href="{{ route('product.show', $item->variation->product->slug) }}">
                                    <img src="{{ $item->variation->product->main_image }}"
                                        alt="{{ $item->variation->product->name }}"
                                        class="img-fluid rounded"
                                        style="max-height: 80px; object-fit: contain;">
                                </a>
                            </div>

                            {{-- Информация о товаре --}}
                            <div class="col-9 col-md-6">
                                <a href="{{ route('product.show', $item->variation->product->slug) }}"
                                    class="text-decoration-none text-dark">
                                    <h6 class="mb-1">{{ $item->variation->product->name }}</h6>
                                </a>
                                @if($item->variation->name)
                                <small class="text-muted d-block">{{ $item->variation->name }}</small>
                                @endif
                                <small class="text-muted">Артикул: {{ $item->variation->sku }}</small>
                            </div>

                            {{-- Количество и цена --}}
                            <div class="col-12 col-md-4 mt-3 mt-md-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    {{-- Количество (как на странице продукта) --}}
                                    <div class="quantity-control d-flex align-items-center border rounded" style="width: 130px;">
                                        <button class="btn btn-link text-dark decrement-quantity"
                                            data-id="{{ $item->id }}"
                                            data-quantity="{{ $item->quantity }}"
                                            style="width: 32px;">−</button>
                                        <input type="number"
                                            class="form-control border-0 text-center quantity-input"
                                            value="{{ $item->quantity }}"
                                            data-id="{{ $item->id }}"
                                            min="1"
                                            max="{{ $item->variation->stock }}"
                                            style="width: 60px;">
                                        <button class="btn btn-link text-dark increment-quantity"
                                            data-id="{{ $item->id }}"
                                            data-quantity="{{ $item->quantity }}"
                                            style="width: 32px;">+</button>
                                    </div>

                                    {{-- Цена --}}
                                    <div class="text-end ms-2">
                                        <strong class="item-total">{{ number_format($item->total, 0, '.', ' ') }} ₽</strong>
                                        <div class="small text-muted">{{ number_format($item->price, 0, '.', ' ') }} ₽ / шт</div>
                                    </div>

                                    {{-- Удалить --}}
                                    <button class="btn btn-link text-danger remove-item"
                                        data-id="{{ $item->id }}"
                                        data-url="{{ route('cart.remove', $item->id) }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Итого --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Итого</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Товары (<span id="total-items">{{ $cartItems->sum('quantity') }}</span> шт.)</span>
                        <span id="cart-subtotal">{{ number_format($total, 0, '.', ' ') }} ₽</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Скидка</span>
                        <span class="text-success">0 ₽</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <strong>Итого к оплате:</strong>
                        <strong class="fs-5" id="cart-total">{{ number_format($total, 0, '.', ' ') }} ₽</strong>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-dark-green text-center w-100 py-3">
                        Перейти к оформлению
                    </a>

                    <div class="text-center mt-3">
                        <a href="{{ route('index') }}" class="text-decoration-none small">
                            ← Продолжить покупки
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    {{-- Пустая корзина --}}
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 text-center py-5">
            <h3 class="mt-4">Корзина пуста</h3>
            <p class="text-muted mb-4">Добавьте товары в корзину, чтобы оформить заказ</p>
            <a href="{{ route('index') }}" class="btn-dark-green">
                Перейти к покупкам
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Хранилище для отслеживания активных запросов
        let activeRequests = new Map();

        // Debounce функция
        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Функция обновления количества
        async function updateQuantity(itemId, quantity) {
            if (activeRequests.has(itemId)) return;

            activeRequests.set(itemId, true);

            try {
                const response = await fetch(`/cart/update/${itemId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const itemElement = document.querySelector(`.cart-item[data-id="${itemId}"]`);
                    if (!itemElement) return;

                    const itemTotalSpan = itemElement.querySelector('.item-total');
                    if (itemTotalSpan) {
                        itemTotalSpan.textContent = data.total.toLocaleString() + ' ₽';
                    }

                    const cartSubtotalSpan = document.getElementById('cart-subtotal');
                    const cartTotalSpan = document.getElementById('cart-total');
                    const totalItemsSpan = document.getElementById('total-items');

                    if (cartSubtotalSpan) cartSubtotalSpan.textContent = data.cart_total.toLocaleString() + ' ₽';
                    if (cartTotalSpan) cartTotalSpan.textContent = data.cart_total.toLocaleString() + ' ₽';
                    if (totalItemsSpan) totalItemsSpan.textContent = data.total_items;

                    const quantityInput = itemElement.querySelector('.quantity-input');
                    if (quantityInput) {
                        quantityInput.value = quantity;
                        quantityInput.max = data.max_stock;
                    }

                    const decrementBtn = itemElement.querySelector('.decrement-quantity');
                    const incrementBtn = itemElement.querySelector('.increment-quantity');
                    if (decrementBtn) decrementBtn.dataset.quantity = quantity;
                    if (incrementBtn) incrementBtn.dataset.quantity = quantity;
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                activeRequests.delete(itemId);
            }
        }

        const debouncedUpdate = debounce(updateQuantity, 300);

        function changeQuantity(itemId, delta) {
            const itemElement = document.querySelector(`.cart-item[data-id="${itemId}"]`);
            if (!itemElement) return;

            const quantityInput = itemElement.querySelector('.quantity-input');
            if (!quantityInput) return;

            let newValue = parseInt(quantityInput.value) + delta;
            const maxStock = parseInt(quantityInput.max);

            if (newValue < 1) newValue = 1;
            if (newValue > maxStock) {
                if (delta > 0) alert('Недостаточно товара на складе');
                return;
            }

            quantityInput.value = newValue;
            debouncedUpdate(itemId, newValue);
        }

        // Обработчики кнопок +/-
        document.querySelectorAll('.increment-quantity').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                changeQuantity(this.dataset.id, 1);
            });
        });

        document.querySelectorAll('.decrement-quantity').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                changeQuantity(this.dataset.id, -1);
            });
        });

        // Обработчик ручного ввода
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.dataset.id;
                let quantity = parseInt(this.value);
                const maxStock = parseInt(this.max);
                const minStock = parseInt(this.min) || 1;

                if (isNaN(quantity) || quantity < minStock) quantity = minStock;
                if (quantity > maxStock) {
                    quantity = maxStock;
                    alert('Недостаточно товара на складе');
                }

                this.value = quantity;
                debouncedUpdate(itemId, quantity);
            });
        });

        // Удаление товара (через форму, без AJAX)
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!confirm('Удалить товар из корзины?')) return;

                // Создаем форму для отправки DELETE запроса
                const url = this.dataset.url;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                // Добавляем CSRF токен
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrfInput);

                // Добавляем метод DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            });
        });
    });
</script>
@endsection