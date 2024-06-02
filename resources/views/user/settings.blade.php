@extends('user.user-account')
@section('account-content')
    <div class="settings-container">
        <form action="{{route('user_update')}}" method="POST">
            @csrf
            @include('components.main-input', ['type'=>'text', 'name'=>'name', 'placeholder'=>'Имя', 'value'=>Auth::user()->name])
            @include('components.main-input', ['type'=>'text', 'name'=>'number', 'placeholder'=>'Номер', 'value'=>Auth::user()->number])
            @include('components.main-input', ['type'=>'password', 'name'=>'password', 'placeholder'=>'Новый пароль'])
            @include('components.main-button', ['type'=>'submit', 'content'=>'Сохранить изменения'])
        </form>
    </div>
@endsection
<style>
    .settings-container {
        padding: 15px;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        width: 920px;
        border-radius: 12px;
    }
    .settings-container form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: end;
    }
</style>
