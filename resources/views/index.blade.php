@extends('layouts.app')

@php $style = 'index'; @endphp

@section('content')
<div class="container">
    @include('partials.index.carousel-discount', [ 'carousel_id' => 'carouselDiscount', 'items' => $discountedProducts, 'interval' => 7000 ])
</div>
<div class="container">
    @include('categories.partials.categories-block', compact('categories'))
</div>
<div class="container">
    @include('partials.index.product-carousel', [ 'title' => 'Сухие корма для кошек', 'carousel_id' => 'carouselDryCatFood', 'items' => $dryCatFood, 'interval' => 7000 ])
</div>
<div class="container">
    @include('partials.index.product-carousel', [ 'title' => 'Сухие корма для собак', 'carousel_id' => 'carouselDryDogFood', 'items' => $dryDogFood, 'interval' => 7000 ])
</div>
@endsection