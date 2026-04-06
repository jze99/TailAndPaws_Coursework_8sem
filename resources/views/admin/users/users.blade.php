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

    <div class="users-table col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5>Пользователи</h5>
                <div class="d-flex gap-2">
                    <form method="GET" action="{{ route('admin.users') }}" class="d-flex gap-2">
                        <input type="text" id="search"
                            name="search"
                            class="form-control form-control-sm"
                            placeholder="Поиск по имени или email..."
                            value="{{ request('search') }}"
                            style="width: 250px;">
                        <button type="submit" class="btn btn-sm btn-dark-green">
                            <i class="bi bi-search"></i> Найти
                        </button>
                        @if(request('search'))
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-orange">
                            <i class="bi bi-x-lg"></i> Сбросить
                        </a>
                        @endif
                    </form>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-dark-green">
                        <i class="bi bi-plus-lg"></i> Добавить пользователя
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Телефон</th>
                                <th>Роль</th>
                                <th>Дата регистрации</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role?->slug === 'super_admin' ? 'danger' : ($user->role?->slug === 'shop_admin' ? 'warning' : 'secondary') }}">
                                        {{ $user->role?->name ?? 'Нет роли' }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-orange p-1" title="Редактировать">
                                            <img src="{{ asset('assets/images/icons/edit-svgrepo-com.svg') }}" alt="Редактировать" width="20" height="20">
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Удалить пользователя «{{ $user->name }}»?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger p-1" type="submit" title="Удалить">
                                                <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Удалить" width="20" height="20">
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Пользователи не найдены</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ps-2 pe-2">
    {{ $users->links() }}
</div>
@endsection