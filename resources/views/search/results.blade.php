@extends('layouts.app')

@section('title', 'Поиск: ' . $query)

@section('content')
<div class="container py-4">
    {{-- Хлебные крошки --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Главная</a>
            </li>
            <li class="breadcrumb-item active">Поиск</li>
        </ol>
    </nav>

    <h1 class="h2 mb-4">Результаты поиска: "{{ $query }}"</h1>

    {{-- Бренды --}}
    @if($brands->count())
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white">
            <h3 class="h5 mb-0">Бренды</h3>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($brands as $brand)
                <div class="col-md-3 col-sm-4 col-6">
                    <a href="{{ route('brands.show', $brand->slug) }}" class="text-decoration-none">
                        <div class="text-center p-3 border rounded hover-shadow">
                            @if($brand->logo)
                            <img src="{{ asset('assets/images/brands/' . $brand->logo) }}"
                                alt="{{ $brand->name }}"
                                class="img-fluid mb-2"
                                style="max-height: 60px;">
                            @else
                            <i class="bi bi-building fs-1 text-secondary"></i>
                            @endif
                            <p class="mb-0 fw-semibold">{{ $brand->name }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Товары --}}
    @if($products->count())
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h3 class="h5 mb-0">Товары ({{ $products->total() }})</h3>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-md-4 col-sm-6">
                    @include('products.partials.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
    @endif

    {{-- Ничего не найдено --}}
    @if($products->isEmpty() && $brands->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-search fs-1 text-muted"></i>
        <h3 class="mt-3">Ничего не найдено</h3>
        <p class="text-muted">Попробуйте изменить поисковый запрос или проверьте орфографию</p>
        <a href="{{ route('index') }}" class="btn btn-dark-green mt-3">Вернуться на главную</a>
    </div>
    @endif
</div>
@endsection