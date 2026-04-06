@extends('layouts.admin')

@section('title', 'Товары')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="products-table col-12 mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Товары</h5>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-dark-green">
                    <i class="bi bi-plus-lg"></i> Добавить товар
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Фото</th>
                                <th>Название</th>
                                <th>Категория</th>
                                <th>Бренд</th>
                                <th>Вариации</th>
                                <th>Цена</th>
                                <th>Остаток</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->main_image }}"
                                        alt="{{ $product->name }}"
                                        style="width: 50px; height: 50px; object-fit: cover;"
                                        class="rounded">
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                </td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td>{{ $product->brand->name ?? '-' }}</td>
                                <td style="min-width: 180px;">
                                    <div class="variations-table">
                                        @foreach($product->variations as $index => $variation)
                                        <div class="d-flex justify-content-between align-items-center small mb-1 tw-bg-orange rounded p-1 tw-text-light-gray
                        {{ $index >= 3 ? 'd-none variations-more' : '' }}">
                                            <span class="text-truncate" style="max-width: 100px;"
                                                title="{{ $variation->name }}">
                                                {{ Str::limit($variation->name, 15) }}
                                            </span>
                                            <span class="text-nowrap">
                                                <span>{{ number_format($variation->price) }} ₽</span>
                                                <span class="ms-1">×{{ $variation->stock }}</span>
                                            </span>
                                        </div>
                                        @endforeach

                                        @if($product->variations->count() > 3)
                                        <a href="#" class="small toggle-variations" data-target="{{ $product->id }}">
                                            Показать ещё {{ $product->variations->count() - 3 }}
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $product->price_range }}</td>
                                <td>
                                    @if($product->total_stock > 0)
                                    <span class="badge bg-success">{{ $product->total_stock }} шт.</span>
                                    @else
                                    <span class="badge bg-danger">Нет</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_active)
                                    <span class="badge bg-success">Активен</span>
                                    @else
                                    <span class="badge bg-secondary">Неактивен</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn btn-orange p-1 d-inline-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;"
                                            title="Редактировать">
                                            <img src="{{ asset('assets/images/icons/edit-svgrepo-com.svg') }}" alt="Редактировать" width="20" height="20">
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Удалить товар «{{ $product->name }}»? Все вариации также будут удалены.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger p-1 d-inline-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;"
                                                title="Удалить">
                                                <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Удалить" width="20" height="20">
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.products.duplicate', $product->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-dark-green p-1 d-inline-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;"
                                                title="Копировать">
                                                <img src="{{ asset('assets/images/icons/copy-svgrepo-com.svg') }}" alt="Копировать" width="20" height="20">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="bi bi-box fs-1 d-block mb-2"></i>
                                    Нет товаров.
                                    <a href="{{ route('admin.products.create') }}">Добавить первый товар</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="ps-2 pe-2">
                    @if(method_exists($products, 'hasPages') && $products->hasPages())
                    {{ $products->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('.toggle-variations').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const container = this.closest('.variations-table');
            const hidden = container.querySelectorAll('.variations-more');
            hidden.forEach(el => el.classList.toggle('d-none'));
            this.textContent = this.textContent.includes('ещё') ? 'Свернуть' : 'Показать ещё';
        });
    });
</script>
@endsection