@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-none d-lg-block">
        <h1 class="h2 mb-4">Панель управления</h1>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card tw-bg-dark-green tw-text-light-gray border-0">
                    <div class="card-body">
                        <h5 class="card-title">Пользователи</h5>
                        <p class="display-5">{{ $totalUsers }}</p>
                        <a href="" class="text-white">Управление →</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card tw-bg-orange tw-text-light-gray border-0">
                    <div class="card-body">
                        <h5 class="card-title">Товары</h5>
                        <p class="display-5">{{ $totalProducts }}</p>
                        <a href="" class="text-white">Управление →</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card tw-bg-dark-green tw-text-light-gray border-0">
                    <div class="card-body">
                        <h5 class="card-title">Заказы</h5>
                        <p class="display-5">{{ $totalOrders }}</p>
                        <a href="" class="text-white">Управление →</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card tw-bg-orange tw-text-light-gray border-0">
                    <div class="card-body">
                        <h5 class="card-title">Выручка</h5>
                        <p class="display-5">{{ $monthlyRevenue }} ₽</p>
                        <span class="text-white">За текущий месяц</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Последние заказы</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Клиент</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $ord)
                            <tr>
                                <td>{{ $ord->order_number }}</td>
                                <td>{{ $ord->customer_name }}</td>
                                <td>{{ $ord->total }}</td>
                                <td>
                                    <span class="badge bg-{{ $ord->delivery_status_color }}">
                                        {{ $ord->delivery_status_name }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Популярные товары</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Кол-во продаж</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($popularProducts as $product)
                                <tr>
                                    <td>{{ $product->variation_name }}</td>
                                    <td class="text-center">{{ $product->total_quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection