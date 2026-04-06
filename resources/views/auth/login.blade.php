@extends('layouts.app')

@php $style = 'login'; @endphp

@section('content')
<div class="container">
    <form action="{{ route('login') }}" method="POST" class="login-form tw-bg-orange tw-text-light-gray w-75 mx-auto p-4 d-flex flex-column justify-content-center gap-4">
        @csrf

        <h3 class="fs-2">Вход на {{ $menuContacts->name }}</h3>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="d-flex flex-column gap-3">
            <input type="email"
                name="email"
                class="form-control w-100 @error('email') is-invalid @enderror"
                placeholder="Введите адрес электронной почты"
                value="{{ old('email') }}">

            <input type="password"
                name="password"
                class="form-control w-100 @error('password') is-invalid @enderror"
                placeholder="Введите пароль">

            <div class="save-checkbox d-flex gap-2 align-items-center">
                <input type="checkbox"
                    id="save_checkbox"
                    name="save_checkbox"
                    class="form-check-input"
                    {{ old('save_checkbox') ? 'checked' : '' }}>
                <label for="save_checkbox">Запомнить меня</label>
            </div>
        </div>

        <input type="submit" class="btn btn-dark-green" value="Войти">

        <a class="text-decoration-underline text-center" href="{{ route('register') }}">
            Еще не зарегистрированы? Зарегистрироваться...
        </a>
    </form>
</div>
@endsection