<div id="{{ $carousel_id }}" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner p-3">
        @foreach ($items as $key => $productVariation)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <div class="row w-100 h-100 mx-auto g-2 g-lg-5">
                <div class="carousel-discount-img col-12 col-lg-6">
                    <a href="{{ route('product.show', $productVariation->product->slug) }}">
                        @if (isset($productVariation->main_image_url))
                        <img src="{{ asset($productVariation->main_image_url) }}" alt="{{ $productVariation->name }}">
                        @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center">
                            <i class="bi bi-image text-secondary"></i>
                        </div>
                        @endif
                    </a>
                </div>
                <div class="col-12 col-lg-6 d-flex flex-column gap-3">
                    <div class="row align-items-start g-3 carousel-discount-header">
                        <h1 class="col-10 fs-3">{{ $productVariation->name }}</h1>
                        <div class="col-2">
                            <div class="discount-badge">
                                -{{ $productVariation->discount_percent }}%
                            </div>
                        </div>
                    </div>
                    <p class="d-none d-lg-block">{{ Str::words($productVariation->product->description, 30, '...') }}</p>
                    <div class="carousel-price">
                        <div class="w-25 d-flex flex-column mx-auto">
                            <span class="original-price fs-4">{{ number_format($productVariation->old_price, 0, ',', ' ') }} ₽</span>
                            <span class="discounted-price fs-2">{{ number_format($productVariation->price, 0, ',', ' ') }} ₽</span>
                        </div>
                    </div>
                    <button class="btn btn-dark-green w-100 p-3 mt-auto">Подробнее... </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carousel_id }}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#{{ $carousel_id }}" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>