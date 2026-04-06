@extends('layouts.admin')

@section('title', 'Заказ ' . $order->order_number)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Заказ #{{ $order->order_number }}</h4>
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary btn-sm">← Назад к списку</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Информация о заказе</h5>
                </div>
                <div class="card-body">
                    <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                    <p><strong>Клиент:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
                    @if($order->shipping_address)
                    <p><strong>Адрес доставки:</strong> {{ $order->shipping_address }}</p>
                    @endif
                    @if($order->comment)
                    <p><strong>Комментарий:</strong> {{ $order->comment }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Обновить статус</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Статус доставки</label>
                            <select name="delivery_status" class="form-select">
                                @foreach($order::getDeliveryStatuses() as $value => $label)
                                <option value="{{ $value }}" {{ $order->delivery_status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Статус оплаты</label>
                            <select name="payment_status" class="form-select">
                                @foreach($order::getPaymentStatuses() as $value => $label)
                                <option value="{{ $value }}" {{ $order->payment_status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark-green">Обновить статус</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Товары в заказе</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Вариация</th>
                            <th>SKU</th>
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
                            <td>{{ $item->sku ?? '—' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, '.', ' ') }} ₽</td>
                            <td>{{ number_format($item->total, 0, '.', ' ') }} ₽</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end fw-bold">Итого:</td>
                            <td class="fw-bold">{{ number_format($order->total, 0, '.', ' ') }} ₽</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection