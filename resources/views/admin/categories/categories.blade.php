@extends('layouts.admin')

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

    <div class="categories-table col-12 mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Категории</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th style="width: 60px">Порядок</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Иконка</th>
                        <th>Изображение</th>
                        <th class="text-center">Активна?</th>
                        <th class="text-center">Действия</th>
                    </thead>
                    <tbody>
                        <tr class="bg-light">
                            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <td>
                                    <select name="parent_id" class="form-select form-select-sm @error('parent_id') is-invalid @enderror">
                                        <option value="">Корневая категория</option>
                                        @foreach($allCategories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                            @for($i = 0; $i < $cat->level; $i++) — @endfor {{ $cat->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" name="name"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        placeholder="Название" value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <textarea name="description"
                                        class="form-control form-control-sm @error('description') is-invalid @enderror"
                                        rows="2" placeholder="Описание">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="file" name="icon"
                                        class="form-control form-control-sm @error('icon') is-invalid @enderror"
                                        accept="image/*">
                                    @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="file" name="image"
                                        class="form-control form-control-sm @error('image') is-invalid @enderror"
                                        accept="image/*">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                    @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-dark-green p-1" title="Добавить категорию">
                                        <img src="{{ asset('assets/images/icons/add-folder-svgrepo-com.svg') }}" alt="Добавить" width="20" height="20">
                                    </button>
                                </td>
                            </form>
                        </tr>

                        @foreach ($categories as $index => $category)
                        <tr class="category-row" data-level="{{ $category->level ?? 0 }}">
                            <td class="text-nowrap">
                                <div class="d-flex gap-1">
                                    @php
                                    $canMoveUp = false;
                                    for ($i = 0; $i < $index; $i++) {
                                        if ($categories[$i]->parent_id == $category->parent_id) {
                                        $canMoveUp = true;
                                        break;
                                        }
                                        }
                                        @endphp
                                        @if($canMoveUp)
                                        <form action="{{ route('admin.categories.move-up', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-link p-0 text-dark" title="Вверх">
                                                <i class="bi bi-arrow-up-short fs-4"></i>
                                            </button>
                                        </form>
                                        @else
                                        <span style="width: 28px"></span>
                                        @endif

                                        @php
                                        $canMoveDown = false;
                                        for ($i = $index + 1; $i < count($categories); $i++) {
                                            if ($categories[$i]->parent_id == $category->parent_id) {
                                            $canMoveDown = true;
                                            break;
                                            }
                                            }
                                            @endphp
                                            @if($canMoveDown)
                                            <form action="{{ route('admin.categories.move-down', $category->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-link p-0 text-dark" title="Вниз">
                                                    <i class="bi bi-arrow-down-short fs-4"></i>
                                                </button>
                                            </form>
                                            @else
                                            <span style="width: 28px"></span>
                                            @endif
                                </div>
                            </td>

                            <td>
                                <div class="category-name" style="display: flex; align-items: center;">
                                    @for($i = 0; $i < ($category->level ?? 0); $i++)
                                        <span style="width: 24px; display: inline-block;"></span>
                                        @endfor

                                        @if(($category->level ?? 0) > 0)
                                        @php
                                        $hasNext = false;
                                        if (isset($categories[$index + 1])) {
                                        $nextLevel = $categories[$index + 1]->level ?? 0;
                                        $currentLevel = $category->level ?? 0;
                                        if ($nextLevel >= $currentLevel) {
                                        $hasNext = true;
                                        }
                                        }
                                        @endphp
                                        @if($hasNext)
                                        <span class="text-muted" style="font-family: monospace;">├─ </span>
                                        @else
                                        <span class="text-muted" style="font-family: monospace;">└─ </span>
                                        @endif
                                        @endif

                                        @if($category->children->count() > 0)
                                        <i class="bi bi-folder-fill tw-text-orange me-2"></i>
                                        @else
                                        <i class="bi bi-file-earmark me-2 text-secondary"></i>
                                        @endif

                                        <strong>{{ $category->name }}</strong>
                                        @if($category->children->count())
                                        <span class="badge bg-secondary ms-2">{{ $category->children->count() }}</span>
                                        @endif
                                </div>
                            </td>

                            <td style="max-width: 200px;">
                                @if($category->description)
                                {{ Str::limit($category->description, 50) }}
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                @if ($category->icon)
                                <img src="{{ asset('assets/images/categories/icons/' . $category->icon) }}" alt="{{ $category->name }}" style="max-height: 30px;">
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                @if ($category->image)
                                <img src="{{ asset('assets/images/categories/images/' . $category->image) }}" alt="{{ $category->name }}" style="max-height: 30px;">
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($category->is_active)
                                <i class="bi bi-check-circle text-success"></i>
                                @else
                                <i class="bi bi-x-circle text-danger"></i>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-orange p-1" title="Редактировать">
                                        <img src="{{ asset('assets/images/icons/edit-svgrepo-com.svg') }}" alt="Редактировать" width="20" height="20">
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post"
                                        onsubmit="return confirm('Удалить категорию «{{ $category->name }}»? Все подкатегории также будут удалены.');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger p-1" type="submit">
                                            <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Удалить" width="20" height="20">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(method_exists($categories, 'hasPages') && $categories->hasPages())
<div class="ps-2 pe-2">
    {{ $categories->links() }}
</div>
@endif
@endsection