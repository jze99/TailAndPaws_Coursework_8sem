@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Редактирование бренда: {{ $brand->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Название <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $brand->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Страна</label>
                        <input type="text" name="country"
                            class="form-control @error('country') is-invalid @enderror"
                            value="{{ old('country', $brand->country) }}">
                        @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Описание</label>
                    <textarea name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4">{{ old('description', $brand->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Сайт</label>
                        <input type="url" name="website"
                            class="form-control @error('website') is-invalid @enderror"
                            value="{{ old('website', $brand->website) }}"
                            placeholder="https://">
                        @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Логотип</label>
                        @if($brand->logo)
                        <div class="mb-2">
                            <img src="{{ asset('assets/images/brands/' . $brand->logo) }}"
                                alt="{{ $brand->name }}"
                                style="max-height: 60px;">
                        </div>
                        @endif
                        <input type="file" name="logo"
                            class="form-control @error('logo') is-invalid @enderror"
                            accept="image/*">
                        <small class="text-muted">Оставьте пустым, чтобы не менять</small>
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1"
                            class="form-check-input" id="is_active"
                            {{ old('is_active', $brand->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Активен
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-orange p-2">
                        <img src="{{ asset('assets/images/icons/save-svgrepo-com.svg') }}" alt="Обновить" width="20" height="20">
                    </button>
                    <a href="{{ route('admin.brands') }}" class="btn btn-dark-green p-2 d-flex gap-2 align-items-center">
                        <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Обновить" width="20" height="20">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection