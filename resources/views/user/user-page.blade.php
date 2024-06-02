@extends('welcome')
@section('title', 'Продавец')
@section('content')
    <div class="user-page-container">
        <div class="user-profile">
            <div class="account-user-menu">
                <div class="user-avatar-container">
                    @if($user->images)
                        <img src="{{ asset('storage/' . $user->images) }}" alt="User Avatar">
                    @else
                        <img src="{{ asset('image/header/user-logo.svg') }}" alt="User Avatar">
                    @endif
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
                    <a href="{{route('user_page_products', $user->id)}}">Объявления</a>
                    <a href="{{route('user_page_reviews', $user->id)}}">Отзывы</a>
                </div>
            </div>
        </div>
        <div class="user-data-container">
           @yield('data')
        </div>
    </div>
@endsection
<style>
    .user-page-container {
        display: flex;
        gap: 15px;
        align-items: start;
        margin-top: 15px
    }
    .account-user-rating-top {
        font-weight: 700;
        font-size: 40px;
        display: flex;
        gap: 10px;
    }
    .user-rating-image {
        display: flex;
    }
    .user-rating-image img {
        height: 40px;
        width: 40px;
    }
    .account-user-menu h1 {
        font-weight: 700;
        font-size: 30px;
    }
    .account-user-rating {
        font-weight: 400;
        font-size: 18px;
    }
    .account-navbar {
        font-weight: 400;
        font-size: 18px;
        display: flex;
        flex-direction: column;
        margin-top: 25px;
        gap: 10px;
    }
    .user-profile {
        padding: 15px;
        border-radius: 12px;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        width: 320px;
    }
    .user-avatar-container {
        height: 100px;
        width: 100px;
        border-radius: 100px;
        overflow: hidden;
    }
    .user-avatar-container img {
        height: 100px;
        width: 100px;
        object-fit: cover;
    }
</style>
