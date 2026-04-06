@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Редактирование категории: {{ $category->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="col-12 mb-4">
                            <label class="form-label">Название <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">Корневая категория</option>
                                @foreach($allCategories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}
                                    {{ $cat->disabled ? 'disabled' : '' }}>
                                    @for($i = 0; $i < $cat->level; $i++) — @endfor {{ $cat->name }}
                                        @if($cat->disabled) (недоступно) @endif
                                </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Описание</label>
                        <textarea name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="4">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Иконка</label>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="remove_icon" value="1"
                                class="form-check-input" id="remove_icon"
                                {{ old('remove_icon') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remove_icon">
                                Удалить иконку
                            </label>
                        </div>
                        @if($category->icon)
                        <div class="mb-2">
                            <img src="{{ asset('assets/images/categories/icons/' . $category->icon) }}"
                                alt="{{ $category->name }}"
                                style="max-height: 60px;">
                        </div>
                        @endif
                        <input type="file" name="icon"
                            class="form-control @error('icon') is-invalid @enderror"
                            accept="image/*">
                        <small class="text-muted">Оставьте пустым, чтобы не менять</small>
                        @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Изображение</label>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="remove_image" value="1"
                                class="form-check-input" id="remove_image"
                                {{ old('remove_image') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remove_image">
                                Удалить изображение
                            </label>
                        </div>
                        @if($category->image)
                        <div class="mb-2">
                            <img src="{{ asset('assets/images/categories/images/' . $category->image) }}"
                                alt="{{ $category->name }}"
                                style="max-height: 60px;">
                        </div>
                        @endif
                        <input type="file" name="image"
                            class="form-control @error('image') is-invalid @enderror"
                            accept="image/*">
                        <small class="text-muted">Оставьте пустым, чтобы не менять</small>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1"
                            class="form-check-input" id="is_active"
                            {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Активен
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-orange p-2">
                        <img src="{{ asset('assets/images/icons/save-svgrepo-com.svg') }}" alt="Обновить" width="20" height="20">
                    </button>
                    <a href="{{ route('admin.categories') }}" class="btn btn-dark-green p-2 d-flex gap-2 align-items-center">
                        <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Обновить" width="20" height="20">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection