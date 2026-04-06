@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Создание роли</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Название роли <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control @error('slug') is-invalid @enderror"
                        name="slug"
                        value="{{ old('slug') }}">
                    <small class="text-muted">Уникальный идентификатор роли (например: admin, manager)</small>
                    @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Описание</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        name="description"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Права доступа</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    id="perm_{{ $permission->id }}">
                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-dark-green p-2 d-flex gap-1 align-items-center justify-content-center" title="Добавить роль">
                        <img src="{{ asset('assets/images/icons/add-folder-svgrepo-com.svg') }}" alt="Добавить" width="20" height="20">
                    </button>
                    <a href="{{ route('admin.roles') }}" class="btn btn-orange p-2 d-flex gap-1 align-items-center">
                        <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Отмена" width="20" height="20">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection