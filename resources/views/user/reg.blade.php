@extends('welcome')
@section('title', 'Регистрация')
@section('content')
<form class="auth-form-container" method='POST' action="{{ route('reg_post') }}">
  @csrf
  <h2>Регистрация</h2>
  @include('components.main-input', ['name' => 'name', 'type' => 'text', 'placeholder' => 'Имя'])
  @include('components.main-input', ['name' => 'number', 'type' => 'text', 'placeholder' => 'Номер телефона'])
  @include('components.main-input', ['name' => 'password', 'type' => 'password', 'placeholder' => 'Пароль'])
  @include('components.main-input', ['name' => 'password_repeat', 'type' => 'password', 'placeholder' => 'Повторите пароль'])
  <p>Уже есть аккаунт? <a href="{{ route("login") }}">Войти</a></p>
  <div class="auth-button-block">
    @include('components.main-button', ["type" => 'submit', "content" => "Зарегистрироваться"])
  </div>
  
</form>
@endsection

<style>
  .auth-form-container {
    width: 430px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
    border-radius: 12px;
  }
  
  .auth-form-container a {
    font-weight: 500;
  }

  .auth-button-block {
    width: 100%;
    display: flex;
    justify-content: end;
  }
</style>