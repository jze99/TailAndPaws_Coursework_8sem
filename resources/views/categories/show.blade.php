@extends('layouts.app')

@section('title', $category->name)

@php $style = 'category'; @endphp

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Главная</a>
            </li>
            @foreach($category->breadcrumbs as $crumb)
            @if($loop->last)
            <li class="breadcrumb-item active">{{ $crumb['name'] }}</li>
            @else
            <li class="breadcrumb-item">
                <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
            </li>
            @endif
            @endforeach
        </ol>
    </nav>

    <div class="d-flex flex-column gap-3 p-5 mb-4 tw-bg-dark-green tw-text-light-gray align-items-center">
        <h1 class="fs-2">{{ $category->name }}</h1>

        @if($category->description)
        <small class="lead text-center d-none d-lg-block mt-3">{{ $category->description }}</small>
        @endif
    </div>

    {{-- Подкатегории --}}
    @if($children->count())
    <div class="row mb-5 d-none d-lg-block">
        <div class="col-12">
            <h3 class="fs-4 mb-4 text-center">Подкатегории</h3>
            @include('categories.partials.categories-block', ['categories' => $children])
        </div>
    </div>
    @endif

    {{-- Продукты --}}
    <div class="row">
        <div class="col-12 col-md-4 col-lg-3" class="h-100">
            <div class="d-md-none col-12 mb-3">
                <button class="btn-dark-green w-100 p-3" type="button" onclick="toggleFilters()">
                    <span id="btn-text">Показать фильтры</span>
                </button>
            </div>
            <div id="mobile-filters" class="d-none d-md-block filters tw-bg-orange tw-text-light-gray p-3">
                <button type="button" class="d-md-none close-btn" onclick="toggleFilters()">&times;</button>

                {{-- ФОРМА ФИЛЬТРОВ --}}
                <form method="GET" action="{{ route('category.show', $category->full_slug) }}" class="filters tw-bg-orange tw-text-light-gray p-3" id="filter-form">

                    {{-- Бренды --}}
                    @if($brands->count())
                    <div class="row align-items-start">
                        <div class="d-flex flex-column justify-content-between col-12 p-3 mb-3 tw-text-light-gray">
                            <p class="form-label fw-semibold mb-3">Бренды</p>
                            <div class="brands-list" style="max-height: 50%; overflow-y: auto;">
                                @foreach($brands as $brand)
                                <div class="form-check mb-2">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="brands[]"
                                        value="{{ $brand->id }}"
                                        id="brand_{{ $brand->id }}"
                                        {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="brand_{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Цена --}}
                    <div class="row align-items-start">
                        <div class="d-flex flex-column justify-content-between col-12 p-3 mb-3 tw-text-light-gray">
                            <p class="form-label fw-semibold mb-2">Цена</p>
                            @include('categories.partials.ui-slider', [
                            'field' => 'price',
                            'max' => $maxPrice,
                            'min' => $minPrice,
                            'step' => 25,
                            'currentMin' => request('price-min', $minPrice),
                            'currentMax' => request('price-max', $maxPrice)
                            ])
                        </div>
                    </div>

                    {{-- Кнопки --}}
                    <div class="d-flex flex-column justify-content-between col-12 p-3 mb-3 tw-text-light-gray">
                        <button type="submit" class="btn-dark-green" id="apply-filters-btn">Применить фильтры</button>
                        <a href="{{ route('category.show', $category->full_slug) }}" class="btn btn-danger mt-2 text-center d-block" id="reset-filters-btn">Сбросить</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- БЛОК С КАРТОЧКАМИ --}}
        <div class="col-12 col-md-8 col-lg-9" id="products-container">
            @if($products->count())
            <div class="row g-2 g-lg-4" id="products-grid">
                @foreach($products as $product)
                @include('products.partials.product-card', compact('product'))
                @endforeach
            </div>

            {{ $products->links() }}
            @else
            <div class="alert alert-dark-green">
                В этой категории пока нет товаров.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const filters = document.getElementById('mobile-filters');
    const btnText = document.getElementById('btn-text');
    const body = document.body;

    function toggleFilters() {
        if (filters.classList.contains('d-none')) {
            filters.classList.remove('d-none');
            filters.classList.add('mobile-open');
            body.classList.add('filters-open');
            btnText.textContent = 'Скрыть фильтры';
        } else {
            filters.classList.add('d-none');
            filters.classList.remove('mobile-open');
            body.classList.remove('filters-open');
            btnText.textContent = 'Показать фильтры';
        }
    }

    function scrollToProducts() {
        const productsContainer = document.getElementById('products-container');
        if (productsContainer) {
            const offset = 80;
            const elementPosition = productsContainer.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filter-form');
        const resetBtn = document.getElementById('reset-filters-btn');

        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                localStorage.setItem('scrollToProducts', 'true');
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                localStorage.setItem('scrollToProducts', 'true');
            });
        }

        if (localStorage.getItem('scrollToProducts') === 'true') {
            setTimeout(() => {
                scrollToProducts();
                localStorage.removeItem('scrollToProducts');
            }, 300);
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.toString().length > 0) {
            setTimeout(() => {
                scrollToProducts();
            }, 300);
        }
    });
</script>
@endsection