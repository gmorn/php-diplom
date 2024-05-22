@extends('welcome')
@section('title', 'Вход')
@section('content')
<form class="auth-form-container" method='POST' action="{{ route('login_post') }}">
  @csrf
  <h2>Вход</h2>
  @include('components.main-input', ['name' => 'number', 'type' => 'text', 'placeholder' => 'Номер телефона'])
  @include('components.main-input', ['name' => 'password', 'type' => 'password', 'placeholder' => 'Пароль'])
  <p>Нет аккаунта? <a href="{{ route("reg") }}">Зарегистрироваться</a></p>
  <div class="auth-button-block">
    @include('components.main-button', ["type" => "submit", "content" => "Войти"])
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