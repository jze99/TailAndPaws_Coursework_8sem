@extends('layouts.app')

@php $style = 'login'; @endphp

@section('content')
<div class="container">
    <form action="{{ route('register') }}" method="post" class="login-form tw-bg-orange tw-text-light-gray w-75 mx-auto p-4 d-flex flex-column justify-content-center gap-4">
        @csrf

        <h3 class="fs-2">Регистрация на {{ $menuContacts->name }}</h3>

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
            <input type="text" name="name" class="form-control w-100 @error('name') is-invalid @enderror"
                placeholder="Введите Ваше имя" value="{{ old('name') }}">

            <input type="email" name="email" class="form-control w-100 @error('email') is-invalid @enderror"
                placeholder="Введите адрес электронной почты" value="{{ old('email') }}">

            <input type="tel" name="phone" id="phone-mask" class="form-control w-100 @error('phone') is-invalid @enderror"
                placeholder="+7(___)-___-__-__" value="{{ old('phone') }}">

            <input type="password" name="password" class="form-control w-100 @error('password') is-invalid @enderror"
                placeholder="Введите пароль" oncopy="return false">

            <input type="password" name="password_confirmation" class="form-control w-100"
                placeholder="Повторите пароль" oncopy="return false">
        </div>

        <div class="save-processing d-flex gap-2 align-items-center">
            <input type="checkbox" id="save_processing" name="save_checkbox" class="form-check-input @error('save_checkbox') is-invalid @enderror"
                {{ old('save_checkbox') ? 'checked' : '' }}>
            <label for="save_processing">Согласие на обработку персональных данных</label>
        </div>

        <input type="submit" class="btn btn-dark-green" value="Зарегистрироваться">

        <a class="text-decoration-underline text-center" href="{{ route('login') }}">
            Уже зарегистрированы? Войти...
        </a>
    </form>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/phone_mask.js') }}"></script>
@endsection