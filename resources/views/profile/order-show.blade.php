@extends('layouts.app')

@section('title', 'Заказ ' . $order->order_number)

@php $style = 'profile'; @endphp

@section('content')
<div class="container py-4">
    @include('profile.partials.profile-sidebar', compact('user'))
    <div class="col-md-9">
        <div class="card border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">Заказ #{{ $order->order_number }}</h4>
                    <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary btn-sm">
                        ← Назад
                    </a>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Дата заказа:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Способ доставки:</strong>
                            @switch($order->delivery_method)
                            @case('courier') Курьером @break
                            @case('pickup') Самовывоз @break
                            @case('express') Экспресс @break
                            @endswitch
                        </p>
                        <p><strong>Статус доставки:</strong>
                            <span class="badge bg-{{ $order->delivery_status_color }}">
                                {{ $order->delivery_status_name }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Способ оплаты:</strong>
                            @switch($order->payment_method)
                            @case('cash') Наличными при получении @break
                            @case('card') Картой при получении @break
                            @case('online') Онлайн-оплата @break
                            @endswitch
                        </p>
                        <p><strong>Статус оплаты:</strong>
                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ $order->payment_status_name }}
                            </span>
                        </p>
                        @if($order->shipping_address)
                        <p><strong>Адрес доставки:</strong> {{ $order->shipping_address }}</p>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Товар</th>
                                <th>Вариация</th>
                                <th>Кол-во</th>
                                <th>Цена</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->variation_name ?? '—' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, '.', ' ') }} ₽</td>
                                <td>{{ number_format($item->total, 0, '.', ' ') }} ₽</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="4" class="text-end fw-bold">Итого:</td>
                                <td class="fw-bold">{{ number_format($order->total, 0, '.', ' ') }} ₽</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->comment)
                <div class="mt-4">
                    <p><strong>Комментарий к заказу:</strong></p>
                    <p class="text-muted">{{ $order->comment }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection