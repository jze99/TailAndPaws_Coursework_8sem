@extends('layouts.app')

@section('title', 'Личный кабинет')

@php $style = 'profile'; @endphp

@section('content')
<div class="container py-4">

    @include('profile.partials.profile-sidebar', compact('user'))

    <div class="col-md-9">
        <div class="card border-0">
            <div class="card-body p-4">
                <h4 class="mb-4">Мои заказы</h4>

                @if($activeOrders->count())
                <h5 class="mb-3">Активные заказы</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>№ заказа</th>
                                <th>Дата</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ number_format($order->total, 0, '.', ' ') }} ₽</td>
                                <td>
                                    <span class="badge bg-{{ $order->delivery_status_color }}">
                                        {{ $order->delivery_status_name }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('profile.order.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                        Детали
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                @if($archiveOrders->count())
                <h5 class="mb-3">Архив заказов</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>№ заказа</th>
                                <th>Дата</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archiveOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ number_format($order->total, 0, '.', ' ') }} ₽</td>
                                <td>
                                    <span class="badge bg-{{ $order->delivery_status_color }}">
                                        {{ $order->delivery_status_name }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('profile.order.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                        Детали
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                @if($activeOrders->isEmpty() && $archiveOrders->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">У вас пока нет заказов</p>
                    <a href="{{ route('index') }}" class="btn btn-dark-green mt-3">Перейти к покупкам</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection