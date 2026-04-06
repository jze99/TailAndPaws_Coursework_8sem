@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Редактирование права: {{ $permission->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Название <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        value="{{ old('name', $permission->name) }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control @error('slug') is-invalid @enderror"
                        name="slug"
                        value="{{ old('slug', $permission->slug) }}">
                    <small class="text-muted">Уникальный идентификатор (например: manage_cart, admin_access)</small>
                    @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Группа</label>
                    <input type="text"
                        class="form-control @error('group') is-invalid @enderror"
                        name="group"
                        value="{{ old('group', $permission->group) }}"
                        placeholder="Например: cart, orders, products, admin">
                    <small class="text-muted">Для группировки прав в интерфейсе</small>
                    @error('group')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Описание</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        name="description"
                        rows="3">{{ old('description', $permission->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-dark-green p-2 d-flex gap-1 align-items-center justify-content-center" title="Сохранить изменения">
                        <img src="{{ asset('assets/images/icons/edit-svgrepo-com.svg') }}" alt="Сохранить" width="20" height="20">
                        Сохранить
                    </button>
                    <a href="{{ route('admin.permissions') }}" class="btn btn-orange p-2 d-flex gap-1 align-items-center">
                        <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Отмена" width="20" height="20">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection