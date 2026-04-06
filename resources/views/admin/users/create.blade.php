@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Создание пользователя</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Имя <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="text"
                        class="form-control @error('phone') is-invalid @enderror"
                        name="phone" id="phone-mask" placeholder="+7(___)-___-__-__"
                        value="{{ old('phone') }}">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Пароль <span class="text-danger">*</span></label>
                    <input type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password">
                    <small class="text-muted">Минимум 8 символов</small>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Подтверждение пароля <span class="text-danger">*</span></label>
                    <input type="password"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation">
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Роль <span class="text-danger">*</span></label>
                    <select class="form-select @error('role_id') is-invalid @enderror" name="role_id">
                        <option value="">Выберите роль</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-dark-green p-2 d-flex gap-1 align-items-center justify-content-center" title="Добавить пользователя">
                        <img src="{{ asset('assets/images/icons/add-folder-svgrepo-com.svg') }}" alt="Добавить" width="20" height="20">
                        Добавить
                    </button>
                    <a href="{{ route('admin.users') }}" class="btn btn-orange p-2 d-flex gap-1 align-items-center">
                        <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Отмена" width="20" height="20">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/phone_mask.js') }}"></script>
@endsection