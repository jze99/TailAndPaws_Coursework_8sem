@extends('layouts.app')

@section('title', $product->name)

@php $style = 'product'; @endphp

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" id="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Главная</a>
            </li>
            @if($product->category)
            @foreach($product->category->breadcrumbs as $crumb)
            <li class="breadcrumb-item">
                <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
            </li>
            @endforeach
            @endif
            <li class="breadcrumb-item active" id="breadcrumb-product">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="product-gallery">
                <div class="main-image mb-3">
                    <img id="main-product-image"
                        src="{{ $defaultVariation ? $defaultVariation->main_image_url : $product->main_image }}"
                        alt="{{ $product->name }}"
                        class="img-fluid rounded w-100"
                        style="height: 400px; object-fit: contain;">
                </div>

                @php
                $images = $defaultVariation ? $defaultVariation->images : collect();
                @endphp

                @if($images->count() > 1)
                <div class="thumbnail-list d-flex gap-2 overflow-auto" id="thumbnail-list">
                    @foreach($images as $index => $image)
                    <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}"
                        onclick="changeMainImage('{{ $image->url }}', this)">
                        <img src="{{ $image->url }}"
                            alt="{{ $product->name }}"
                            class="img-fluid rounded"
                            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="product-info">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    @if($defaultVariation && $defaultVariation->sku)
                    <small class="text-muted" id="product-sku">Артикул: {{ $defaultVariation->sku }}</small>
                    @endif
                    @if($product->brand)
                    <a href="{{ route('brands.show', $product->brand->slug) }}">
                        <small class="text-muted text-decoration-underline">{{ $product->brand->name }}</small>
                    </a>
                    @endif
                </div>

                <h1 id="product-name" class="h2 mb-3">{{ $product->name }}</h1>

                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="d-flex align-items-center text-orange">
                        <img src="{{ asset('assets/images/icons/star-alt-4-svgrepo-com.svg') }}" width="25"
                            height="25" alt="rating">
                        <span class="ms-1 fw-bold">{{ $product->rating['score'] ?? '4.9' }}</span>
                    </div>
                    <a href="#reviews" class="text-decoration-none">
                        <small>{{ $product->rating['count'] ?? '0' }} отзывов</small>
                    </a>
                </div>

                @php
                $defaultVariation = $product->default_variation;
                $price = $defaultVariation ? $defaultVariation->price : $product->min_price;
                $oldPrice = $defaultVariation ? $defaultVariation->old_price : null;
                $hasStock = $defaultVariation ? $defaultVariation->stock > 0 : false;
                @endphp

                <div class="price-block mb-3" id="price-block">
                    @if($oldPrice && $oldPrice > $price)
                    <span class="text-muted text-decoration-line-through fs-5 me-2" id="old-price">
                        {{ number_format($oldPrice, 0, '.', ' ') }} ₽
                    </span>
                    <span class="text-danger fs-1 fw-bold" id="current-price">
                        {{ number_format($price, 0, '.', ' ') }} ₽
                    </span>
                    <span class="badge bg-danger ms-2" id="discount-badge">-{{ $defaultVariation->discount_percent }}%</span>
                    @else
                    <span class="fs-1 fw-bold text-success" id="current-price">
                        {{ number_format($price, 0, '.', ' ') }} ₽
                    </span>
                    @endif
                </div>

                <div class="stock-block mb-3" id="stock-block">
                    @if($hasStock)
                    <span class="text-success">
                        <i class="bi bi-check-circle-fill"></i> В наличии
                    </span>
                    @if($defaultVariation && $defaultVariation->stock < 10)
                        <small class="text-muted ms-2" id="stock-count">(осталось {{ $defaultVariation->stock }} шт.)</small>
                        @endif
                        @else
                        <span class="text-danger">
                            <i class="bi bi-x-circle-fill"></i> Нет в наличии
                        </span>
                        @endif
                </div>

                @if($product->variations->count() > 1)
                <div class="variations-block mb-3">
                    <label class="fw-semibold mb-2">Варианты:</label>
                    <div class="d-flex flex-wrap gap-2" id="variations-list">
                        @foreach($product->variations as $variation)
                        @php
                        $imageUrls = $variation->images->map(function($image) {
                        return $image->url;
                        })->values()->toArray();
                        @endphp
                        <button type="button"
                            class="btn btn-outline-secondary variation-btn {{ $defaultVariation && $defaultVariation->id == $variation->id ? 'active' : '' }}"
                            data-variation-id="{{ $variation->id }}"
                            data-price="{{ $variation->price }}"
                            data-old-price="{{ $variation->old_price }}"
                            data-sku="{{ $variation->sku }}"
                            data-stock="{{ $variation->stock }}"
                            data-full-name="{{ $variation->name ?? $product->name }}"
                            data-discount-percent="{{ $variation->discount_percent }}"
                            data-images='{{ json_encode($imageUrls) }}'
                            {{ !$variation->stock ? 'disabled' : '' }}>
                            {{ $variation->name ?? $variation->sku }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="cart-block mb-4">
                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2" id="cart-form">
                        @csrf
                        <input type="hidden" name="variation_id" id="variation-id" value="{{ $defaultVariation->id ?? '' }}">
                        <div class="quantity-selector d-flex border rounded" style="width: 120px;">
                            <button type="button" class="btn btn-link px-2" onclick="updateQuantity(-1)">-</button>
                            <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="{{ $defaultVariation->stock ?? 0 }}"
                                class="form-control border-0 text-center" style="width: 50px;">
                            <button type="button" class="btn btn-link px-2" onclick="updateQuantity(1)">+</button>
                        </div>
                        <button type="submit" class="btn-dark-green flex-grow-1" id="add-to-cart-btn" {{ !$hasStock ? 'disabled' : '' }}>
                            {{ $hasStock ? 'В корзину' : 'Нет в наличии' }}
                        </button>
                    </form>
                </div>

                <div class="delivery-block border-top pt-3">
                    <div class="row g-2">
                        <div class="col-12 col-sm-4">
                            <div class="delivery-method p-2 rounded text-center">
                                <i class="bi bi-lightning-charge fs-4"></i>
                                <small class="d-block">Экспресс</small>
                                <small class="text-muted">Платно, за 1 час</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="delivery-method p-2 rounded text-center">
                                <i class="bi bi-truck fs-4"></i>
                                <small class="d-block">Доставка</small>
                                <small class="text-muted">Бесплатно</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="delivery-method p-2 rounded text-center">
                                <i class="bi bi-shop fs-4"></i>
                                <small class="d-block">Самовывоз</small>
                                <small class="text-muted">Бесплатно</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Описание и характеристики товара --}}
    <div class="row mt-5">
        <div class="col-12">
            @php
            $hasAttributes = $product->attributes->count() > 0;
            $hasDescription = !empty($product->description);
            @endphp

            @if($hasDescription || $hasAttributes)
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                @if($hasDescription)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $hasDescription ? 'active' : '' }}"
                        id="description-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#description"
                        type="button"
                        role="tab">
                        Описание
                    </button>
                </li>
                @endif

                @if($hasAttributes)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ !$hasDescription ? 'active' : '' }}"
                        id="characteristics-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#characteristics"
                        type="button"
                        role="tab">
                        Характеристики
                    </button>
                </li>
                @endif

                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                        id="reviews-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#reviews"
                        type="button"
                        role="tab">
                        Отзывы ({{ $product->rating['count'] ?? '0' }})
                    </button>
                </li>
            </ul>
            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="productTabsContent">
                @if($hasDescription)
                <div class="tab-pane fade {{ $hasDescription ? 'show active' : '' }}"
                    id="description"
                    role="tabpanel"
                    aria-labelledby="description-tab">
                    <p>{{ $product->description }}</p>
                </div>
                @endif

                @if($hasAttributes)
                <div class="tab-pane fade {{ !$hasDescription ? 'show active' : '' }}"
                    id="characteristics"
                    role="tabpanel"
                    aria-labelledby="characteristics-tab">
                    <table class="table table-bordered">
                        @foreach($product->attributes as $attribute)
                        <tr>
                            <th class="bg-light" style="width: 30%;">{{ $attribute->key }}</th>
                            <td>{{ $attribute->value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

                <div class="tab-pane fade"
                    id="reviews"
                    role="tabpanel"
                    aria-labelledby="reviews-tab">
                    <p>Отзывы будут здесь</p>
                </div>
            </div>
            @else
            <div class="border rounded p-3">
                <h4 class="mb-3">Отзывы ({{ $product->rating['count'] ?? '0' }})</h4>
                <p>Отзывы будут здесь</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Переключение главного изображения
    function changeMainImage(url, element) {
        const mainImage = document.getElementById('main-product-image');
        if (mainImage) {
            mainImage.src = url;
        }

        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
        });

        if (element) {
            element.classList.add('active');
        }
    }

    // Обновление количества
    function updateQuantity(delta) {
        const quantityInput = document.getElementById('quantity-input');
        if (!quantityInput) return;

        let newValue = parseInt(quantityInput.value) + delta;
        const max = parseInt(quantityInput.getAttribute('max')) || 999;

        if (newValue < 1) newValue = 1;
        if (newValue > max) newValue = max;

        quantityInput.value = newValue;
    }

    // Переключение вариаций
    document.addEventListener('DOMContentLoaded', function() {
        const variationBtns = document.querySelectorAll('.variation-btn');

        variationBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const variationId = this.dataset.variationId;
                const price = parseFloat(this.dataset.price);
                const oldPrice = parseFloat(this.dataset.oldPrice);
                const sku = this.dataset.sku;
                const stock = parseInt(this.dataset.stock);
                const fullName = this.dataset.fullName;
                const discountPercent = this.dataset.discountPercent;

                // Получаем массив URL изображений из data-images атрибута
                let images = [];
                const imagesData = this.dataset.images;
                if (imagesData) {
                    try {
                        images = JSON.parse(imagesData);
                    } catch (e) {
                        console.error('Error parsing images:', e);
                        images = [];
                    }
                }

                // 1. Обновляем название товара
                const productName = document.getElementById('product-name');
                if (productName && fullName) {
                    productName.textContent = fullName;
                }

                // 2. Обновляем хлебные крошки
                const breadcrumbProduct = document.getElementById('breadcrumb-product');
                if (breadcrumbProduct && fullName) {
                    breadcrumbProduct.textContent = fullName;
                }

                // 3. Обновляем скрытое поле с variation_id
                const variationInput = document.getElementById('variation-id');
                if (variationInput) {
                    variationInput.value = variationId;
                }

                // 4. Обновляем цену
                const priceBlock = document.getElementById('price-block');
                if (priceBlock) {
                    if (oldPrice && oldPrice > price) {
                        priceBlock.innerHTML = `
                            <span class="text-muted text-decoration-line-through fs-5 me-2" id="old-price">
                                ${oldPrice.toLocaleString()} ₽
                            </span>
                            <span class="text-danger fs-1 fw-bold" id="current-price">
                                ${price.toLocaleString()} ₽
                            </span>
                            <span class="badge bg-danger ms-2" id="discount-badge">-${discountPercent}%</span>
                        `;
                    } else {
                        priceBlock.innerHTML = `
                            <span class="fs-1 fw-bold text-success" id="current-price">
                                ${price.toLocaleString()} ₽
                            </span>
                        `;
                    }
                }

                // 5. Обновляем артикул
                const skuElement = document.getElementById('product-sku');
                if (skuElement && sku) {
                    skuElement.innerHTML = `Артикул: ${sku}`;
                }

                // 6. Обновляем наличие
                const stockBlock = document.getElementById('stock-block');
                const cartBtn = document.getElementById('add-to-cart-btn');
                const quantityInput = document.getElementById('quantity-input');

                if (stock > 0) {
                    if (stockBlock) {
                        stockBlock.innerHTML = `
                            <span class="text-success">
                                <i class="bi bi-check-circle-fill"></i> В наличии
                                ${stock < 10 ? `<small class="text-muted ms-2" id="stock-count">(осталось ${stock} шт.)</small>` : ''}
                            </span>
                        `;
                    }
                    if (cartBtn) cartBtn.disabled = false;
                    if (quantityInput) quantityInput.max = stock;
                    cartBtn.textContent = 'В корзину';
                } else {
                    if (stockBlock) {
                        stockBlock.innerHTML = `
                            <span class="text-danger">
                                <i class="bi bi-x-circle-fill"></i> Нет в наличии
                            </span>
                        `;
                    }
                    if (cartBtn) {
                        cartBtn.disabled = true;
                        cartBtn.textContent = 'Нет в наличии';
                    }
                    if (quantityInput) quantityInput.max = 0;
                }

                // 7. Обновляем активный класс кнопок
                variationBtns.forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                // 8. ОБНОВЛЯЕМ ИЗОБРАЖЕНИЯ
                const mainImage = document.getElementById('main-product-image');
                const thumbnailList = document.getElementById('thumbnail-list');

                if (images && images.length > 0) {
                    // Обновляем главное изображение
                    mainImage.src = images[0];

                    // Обновляем миниатюры
                    if (thumbnailList) {
                        if (images.length > 1) {
                            thumbnailList.innerHTML = images.map((imageUrl, index) => `
                                <div class="thumbnail-item ${index === 0 ? 'active' : ''}" 
                                     onclick="changeMainImage('${imageUrl}', this)">
                                    <img src="${imageUrl}" 
                                         alt="Изображение товара"
                                         class="img-fluid rounded"
                                         style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                                </div>
                            `).join('');
                        } else {
                            thumbnailList.innerHTML = '';
                        }
                    }
                } else {
                    // Нет изображений - показываем дефолтное
                    mainImage.src = '/assets/images/products/default.svg';
                    if (thumbnailList) {
                        thumbnailList.innerHTML = '';
                    }
                }
            });
        });
    });
</script>
@endsection