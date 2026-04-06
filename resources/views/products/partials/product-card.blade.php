@php
$defaultVariation = $product->default_variation;
$price = $defaultVariation ? $defaultVariation->price : $product->min_price;
$hasStock = $defaultVariation ? $defaultVariation->stock > 0 : false;
$rating = $product->rating;
@endphp

<div class="col-md-4 col-sm-6 mb-4">
    <div class="card product-card h-100">
        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none product-link">
            <img src="{{ $product->main_image }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-start">
                    <h5 class="fs-4 mb-0">{{ number_format($price, 0, '.', ' ') }} ₽</h5>
                    <div class="d-flex align-items-center text-orange">
                        <img src="{{ asset('assets/images/icons/star-alt-4-svgrepo-com.svg') }}" width="20"
                            height="20" alt="rating">
                        <p class="card-text mb-0 ms-1">{{ $rating['score'] ?? '4.5' }} ({{ $rating['count'] ?? '0' }} отзывов)</p>
                    </div>
                </div>
                <p class="card-text mt-2">{{ Str::limit($product->description, 100) }}</p>
            </div>
        </a>
        <div class="mt-auto p-3 pt-0">
            <form action="{{ route('cart.add') }}" method="POST" class="w-100">
                @csrf
                <input type="hidden" name="variation_id" value="{{ $defaultVariation->id ?? '' }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-dark-green w-100 p-3" {{ !$hasStock ? 'disabled' : '' }}>
                    {{ $hasStock ? 'В корзину' : 'Нет в наличии' }}
                </button>
            </form>
        </div>
    </div>
</div>