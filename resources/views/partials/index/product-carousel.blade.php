@php
$title = $title ?? 'Товары';
$carousel_id = $carousel_id ?? 'productCarousel';
$interval = $interval ?? 5000;
@endphp

@if($items->count())
<div class="container">
    <h1 class="text-center mb-4 fw-medium fs-3">
        <a class="text-decoration-none tw-text-dark-blue hover:tw-text-opacity-90" href="#">
            {{ $title }}
        </a>
    </h1>

    <div id="{{ $carousel_id }}" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($items as $key => $chunk)
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" data-bs-interval="{{ $interval }}">
                <div class="row g-2 justify-content-center">
                    @foreach($chunk as $product)
                    @include('products.partials.product-card', compact('product'))
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Индикаторы -->
        @if($items->count() > 1)
        <div class="carousel-indicators">
            @foreach($items as $key => $chunk)
            <button type="button"
                data-bs-target="#{{ $carousel_id }}"
                data-bs-slide-to="{{ $key }}"
                class="{{ $key === 0 ? 'active' : '' }}"
                aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                aria-label="Slide {{ $key + 1 }}">
            </button>
            @endforeach
        </div>
        @endif

        <!-- Кнопки навигации -->
        <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carousel_id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#{{ $carousel_id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@else
<div class="container text-center">
    <p class="text-muted">Товары не найдены</p>
</div>
@endif