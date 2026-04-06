@extends('layouts.admin')

@section('title', 'Заказы')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5>Заказы</h5>
            <form method="GET" action="{{ route('admin.orders') }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Поиск по номеру..." value="{{ request('search') }}" style="width: 200px;">
                <select name="status" class="form-select form-select-sm" style="width: 150px;">
                    <option value="">Все статусы</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Ожидает</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>В обработке</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Отправлен</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Доставлен</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменён</option>
                </select>
                <button type="submit" class="btn btn-sm btn-dark-green">Фильтр</button>
                @if(request('search') || request('status'))
                <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-secondary">Сбросить</a>
                @endif
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>№ заказа</th>
                            <th>Клиент</th>
                            <th>Сумма</th>
                            <th>Статус доставки</th>
                            <th>Статус оплаты</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name }}<br><small class="text-muted">{{ $order->customer_email }}</small></td>
                            <td>{{ number_format($order->total, 0, '.', ' ') }} ₽</td>
                            <td>
                                <span class="badge bg-{{ $order->delivery_status_color }}">
                                    {{ $order->delivery_status_name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ $order->payment_status_name }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-dark-green">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Заказов не найдено</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection