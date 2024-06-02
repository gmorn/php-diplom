@php use Illuminate\Support\Facades\Auth; @endphp
@extends('welcome')
@section('title', 'Личный кабинет')
@section('content')
    <div class="account-container">
        <div class="account-user-menu">
            <div class="user-avatar-container" onclick="document.getElementById('avatarInput').click()">
                @if($user->images)
                    <img src="{{ asset('storage/' . $user->images) }}" alt="User Avatar">
                @else
                    <img src="{{ asset('image/header/user-logo.svg') }}" alt="User Avatar">
                @endif
                <div class="avatar-edit-button">
                    <img src="{{ asset('image/user-account/edit.svg') }}" alt="Edit Avatar">
                </div>
            </div>
            <input type="file" id="avatarInput" name="avatar" style="display: none;" onchange="uploadAvatar(event)">
            <h1>{{$user->name}}</h1>
            <div class="account-user-rating">
                <div class="account-user-rating-top">
                    @php
                        $rating = round($user->rating, 1);
                        $fullStars = floor($rating);
                        $emptyStars = 5 - $fullStars;
                    @endphp
                    <p>{{ $rating }}</p>
                    <div class="user-rating-image">
                        @for ($i = 0; $i < $fullStars; $i++)
                            <img src="{{ asset('image/user-account/star-true.svg') }}" alt="Full Star">
                        @endfor
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <img src="{{ asset('image/user-account/star-false.svg') }}" alt="Empty Star">
                        @endfor
                    </div>
                </div>
                <p>На основании {{$user->reviewCount}} отзывов</p>
            </div>
            <div class="account-navbar">
                <a href="{{route('user_products')}}">Мои объявления</a>
                <a href="">Чаты</a>
                <a href="">Отзывы</a>
                <a href="{{route('settings',Auth::user())}}">Настройки</a>
            </div>
        </div>
        @yield('account-content')
    </div>
@endsection
<style>
    .account-container {
        margin-top: 15px;
        display: flex;
        gap: 15px;
        align-items: start;
    }

    .account-user-menu {
        display: flex;
        flex-direction: column;
        padding: 15px;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        align-items: start;
        width: 320px;
    }

    .account-user-menu h1 {
        font-weight: 700;
        font-size: 30px;
        margin-top: 10px;
        margin-bottom: 1px;
    }

    .account-navbar {
        margin-top: 25px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        font-weight: 400;
        font-size: 18px;
    }

    .account-user-rating p {
        font-weight: 400;
        font-size: 18px;
    }

    .account-user-rating-top {
        display: flex;
        gap: 10px;
    }

    .account-user-rating-top p {
        font-weight: 700;
        font-size: 40px;
    }

    .account-user-rating-top img {
        height: 40px;
        width: 40px;
    }

    .user-avatar-container {
        position: relative;
        height: 100px;
        width: 100px;
        cursor: pointer;
    }

    .user-avatar-container img {
        height: 100px;
        width: 100px;
        object-fit: cover;
        border-radius: 100px;
        overflow: hidden;
    }

    .avatar-edit-button {
        position: absolute;
        bottom: 0;
        right: 0;
        border-radius: 100px;
        overflow: hidden;
    }

    .avatar-edit-button img {
        height: 35px;
        width: 35px;
        object-fit: cover;
    }
</style>
<script>
    function uploadAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('avatar', file);

            fetch('{{ route('user_upload_avatar') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Ошибка при загрузке аватара');
                    }
                });
        }
    }
</script>
