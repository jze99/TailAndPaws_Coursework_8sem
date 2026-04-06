@extends('layouts.app')

@section('title', 'Бренды')

@php $style = 'brand'; @endphp

@section('content')
<div class="container py-4">
    <h2 class="text-center h2 mb-4">Бренды</h2>

    <div class="row g-4">
        @foreach($brands as $brand)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('brands.show', $brand->slug) }}" class="text-decoration-none">
                <div class="card h-100 text-center hover-shadow border-0 shadow-sm">
                    @if($brand->logo)
                    <img src="{{ $brand->logo_url }}"
                        class="card-img-top p-3"
                        alt="{{ $brand->name }}"
                        style="height: 120px; object-fit: contain;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $brand->name }}</h5>
                        <small class="text-muted">{{ $brand->products_count }} товаров</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{ $brands->links() }}
</div>
@endsection