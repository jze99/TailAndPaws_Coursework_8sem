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

    <div class="permissions-table col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Права доступа</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 25%">Название</th>
                            <th style="width: 15%">Slug</th>
                            <th style="width: 15%">Группа</th>
                            <th style="width: 35%">Описание</th>
                            <th style="width: 10%">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-light">
                            <form action="{{ route('admin.permissions.store') }}" method="POST">
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
                                    <input type="text" name="slug"
                                        class="form-control form-control-sm @error('slug') is-invalid @enderror"
                                        placeholder="slug" value="{{ old('slug') }}">
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" name="group"
                                        class="form-control form-control-sm @error('group') is-invalid @enderror"
                                        placeholder="Группа" value="{{ old('group') }}">
                                    @error('group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" name="description"
                                        class="form-control form-control-sm @error('description') is-invalid @enderror"
                                        placeholder="Описание" value="{{ old('description') }}">
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-dark-green p-1" title="Добавить">
                                        <img src="{{ asset('assets/images/icons/add-folder-svgrepo-com.svg') }}" alt="Добавить" width="20" height="20">
                                    </button>
                                </td>
                            </form>
                        </tr>

                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td><code>{{ $permission->slug }}</code></td>
                            <td>
                                @if ($permission->group)
                                <span class="badge bg-secondary">{{ $permission->group }}</span>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $permission->description ?? '—' }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-orange p-1" title="Редактировать">
                                        <img src="{{ asset('assets/images/icons/edit-svgrepo-com.svg') }}" alt="Редактировать" width="20" height="20">
                                    </a>
                                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST"
                                        onsubmit="return confirm('Удалить право «{{ $permission->name }}»?');">
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
    {{ $permissions->links() }}
</div>
@endsection