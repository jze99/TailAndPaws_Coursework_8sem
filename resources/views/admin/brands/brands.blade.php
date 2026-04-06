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

    <div class="brands-table col-12">
        <div class="card">
            <div class="card-header">
                <h5>Бренды</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Лого</th>
                        <th>Сайт</th>
                        <th>Страна</th>
                        <th class="text-center">Активен?</th>
                        <th class="text-center">Действия</th>
                    </thead>
                    <tbody>
                        <tr class="bg-light">
                            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <td>
                                    <input type="text" name="name"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        placeholder="Название" value="{{ old('name') }}">
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
                                    <input type="file" name="logo"
                                        class="form-control form-control-sm @error('logo') is-invalid @enderror"
                                        accept="image/*">
                                    @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="url" name="website"
                                        class="form-control form-control-sm @error('website') is-invalid @enderror"
                                        placeholder="https://" value="{{ old('website') }}">
                                    @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" name="country"
                                        class="form-control form-control-sm @error('country') is-invalid @enderror"
                                        placeholder="Страна" value="{{ old('country') }}">
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-dark-green p-1" title="Добавить">
                                        <img src="{{ asset('assets/images/icons/add-folder-svgrepo-com.svg') }}" alt="Добавить" width="20" height="20">
                                    </button>
                                </td>
                            </form>
                        </tr>

                        @foreach ($brands as $brand)
                        <tr>
                            <td>{{ $brand->name }}</td>
                            <td style="max-width: 200px;">
                                @if ($brand->description)
                                {{ Str::limit($brand->description, 50) }}
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($brand->logo)
                                <img src="{{ asset('assets/images/brands/' . $brand->logo) }}"
                                    alt="{{ $brand->name }}"
                                    style="max-height: 40px;">
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($brand->website)
                                <a href="{{ $brand->website }}" target="_blank">{{ Str::limit($brand->website, 30) }}</a>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($brand->country)
                                {{ $brand->country }}
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($brand->is_active)
                                <i class="bi bi-check-circle text-success"></i>
                                @else
                                <i class="bi bi-x-circle text-danger"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-orange p-1" title="Редактировать">
                                        <img src="{{ asset('assets/images/icons/edit-svgrepo-com.svg') }}" alt="Редактировать" width="20" height="20">
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="post"
                                        onsubmit="return confirm('Удалить бренд «{{ $brand->name }}»?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger p-1" type="submit" title="Удалить">
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

<div class="ps-2 pe-2">
    @if(method_exists($brands, 'hasPages') && $brands->hasPages())
    {{ $brands->links() }}
    @endif
</div>
@endsection