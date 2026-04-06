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

    <div class="roles-table col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Роли пользователей</h5>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-dark-green">
                    <i class="bi bi-plus-lg"></i> Добавить роль
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Slug</th>
                            <th>Описание</th>
                            <th>Права</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <code>{{ $role->slug }}</code>
                            </td>
                            <td>
                                @if ($role->description)
                                {{ Str::limit($role->description, 100) }}
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($role->permissions->count())
                                @foreach ($role->permissions as $permission)
                                <span class="badge bg-secondary mb-1">{{ $permission->name }}</span>
                                @endforeach
                                @elseif($role->slug === 'super_admin')
                                <span class="text-muted">Все права</span>
                                @else
                                <span class="text-muted">Нет прав</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-orange p-1" title="Редактировать">
                                        <img src="{{ asset('assets/images/icons/edit-svgrepo-com.svg') }}" alt="Редактировать" width="20" height="20">
                                    </a>
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                        onsubmit="return confirm('Удалить роль «{{ $role->name }}»?');">
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
    {{ $roles->links() }}
</div>
@endsection