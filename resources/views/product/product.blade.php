@extends('welcome')
@section('title', 'Страница товара')
@section('content')
    <div class="product-page-container">
        <div class="product-page-data">
            <div class="product-gallery">
                @php
                    $gallery = json_decode($product->gallery);
                @endphp
                    <!-- Большая картинка -->
                <div class="large-image-container">
                    <img src="{{ $gallery[0] }}" alt="Large Product Image" id="large-image" class="large-image">
                </div>
                <!-- Маленькие картинки -->
                <div class="thumbnail-container">
                    @foreach ($gallery as $index => $image)
                        <img src="{{ $image }}" alt="Thumbnail {{ $index }}" class="thumbnail" onclick="updateLargeImage('{{ $image }}')">
                    @endforeach
                </div>
            </div>
            <div class="product-page-data-block">
                <h3>Адрес</h3>
                <p>{{ $product->address }}</p>
            </div>
            <div class="product-page-data-block">
                <h3>Описание</h3>
                <p>{{ $product->description }}</p>
            </div>
            <div class="product-page-data-block">
                <h3>Состояние</h3>
                @if($product->type)
                    <p>Б/У</p>
                @else
                    <p>Новое</p>
                @endif
            </div>
            <div class="product-page-date">
                <p>Размещенно: {{ date('d.m.Y', strtotime($product->created_at)) }}</p>
            </div>
        </div>
        <div class="product-page-user">
            <div class="product-page-user-title">
                <h1>{{ $product->name }}</h1>
                <h1>{{ $product->price }}₽</h1>
            </div>
            <div class="product-page-user-connect-method">
                <div class="connect-method-block">Позвонить <div>{{$product->user->number}}</div></div>
                <form action="{{ route('chat_create', ['userId' => $product->user->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="connect-method-block">Написать <br> <div class="connect-method-block-status">@if($product->user->status) <div class="user-online"></div>Онлайн @else <div class="user-offline"></div>Офлайн @endif</div></button>
                </form>
                <div class="connect-method-block-user-data">
                    <div class="connect-method-block-data">
                        <h4>{{ $product->user->name }}</h4>
                        <div class="connect-method-block-rating">
                            @php
                                $rating = round($product->user->rating, 1);
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
                            <p>{{ $product->user->reviewCount }} Отзывов</p>
                        </div>
                        @php
                            use Carbon\Carbon;

                            $date = Carbon::parse($product->user->created_at)->locale('ru');

                            // Получаем месяц и год в нужном формате
                            $monthYear = $date->translatedFormat('F Y');

                            // Заменяем окончания месяцев
                            $months = [
                                'январь' => 'января',
                                'февраль' => 'февраля',
                                'март' => 'марта',
                                'апрель' => 'апреля',
                                'май' => 'мая',
                                'июнь' => 'июня',
                                'июль' => 'июля',
                                'август' => 'августа',
                                'сентябрь' => 'сентября',
                                'октябрь' => 'октября',
                                'ноябрь' => 'ноября',
                                'декабрь' => 'декабря',
                            ];

                            // Добавляем "я" к окончанию месяца
                            foreach ($months as $original => $modified) {
                                $monthYear = str_replace($original, $modified, $monthYear);
                            }
                        @endphp
                        <h4>{{ 'На WebMarket с ' . $monthYear }}</h4>
                    </div>
                    @if($product->user->images)
                        <img class="user-data-image" src="{{ asset('storage/' . $product->user->images) }}" alt="User Avatar">
                    @else
                        <img class="user-data-image" src="{{asset('image/header/user-logo.svg')}}" alt=""/>
                    @endif
                </div>
                @php
                    $productCount = $product->user->products()->count();
                @endphp
                <a href="{{route('user_page_products', $product->user->id)}}">
                    <div class="connect-method-block">{{ $productCount }} обьявлений пользователя</div>
                </a>
            </div>
            @auth()
                <form action="" class="product-page-form">
                    @component('components.main-input', ['placeholder' => 'Спросите у продовца', 'textarea' => true, 'name' => 'name']) @endcomponent
                    @include('components.main-button', ['type'=>'submit', 'content'=>'Отправить'])
                </form>
            @endauth
        </div>
    </div>
@endsection
<style>
    .user-data-image {
        border-radius: 50%;
        object-fit: cover;
    }
    .product-page-form {
        margin-top: 15px;
        display: flex;
        flex-direction: column;
        align-items: end;
    }
    .product-page-form textarea{
        margin-bottom: 15px;
        height: 150px;
    }
    .product-page-container {
        display: flex;
        gap: 15px;
        align-items: start;
        margin-top: 15px;
    }
    .product-page-data, .product-page-user {
        padding: 15px;
        border-radius: 12px;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
    }
    .product-page-data {
        width: 670px;
    }
    .product-page-user {
        width: 565px;
    }

    .user-online {
        background: #B9DDD9;
        height: 10px;
        width: 10px;
        border-radius: 10px;
    }
    .user-offline {
        background: #FF6868;
        height: 10px;
        width: 10px;
        border-radius: 10px;
    }
    .connect-method-block-status {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .connect-method-block-data h4 {
        font-weight: 500;
        font-size: 14px;
    }
    .connect-method-block-user-data {
        width: 260px;
        height: 77px;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        padding: 7px;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }
    .connect-method-block-user-data img {
        width: 58px;
        height: 58px;
    }
    .connect-method-block {
        width: 260px;
        height: 77px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        transition: 300ms;
        cursor: pointer;
        font-weight: 600;
        font-size: 20px;
        padding: 10px;
        text-align: center;
        border: none;
    }
    .connect-method-block-rating {
        display: flex;
        gap: 5px;
    }
    .connect-method-block-rating img {
        height: 15px;
        width: 15px;
    }
    .user-rating-image {
        display: flex;
        gap: 0;
    }
    .connect-method-block:hover {
        transform: scale(1.03);
    }
    .product-page-user-connect-method {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .product-page-user-title {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    .product-page-user-title h1 {
        font-weight: 700;
        font-size: 30px;
    }

    .product-gallery {
        display: flex;
        flex-direction: column;
    }

    .large-image-container {
        margin-bottom: 10px;
    }

    .large-image {
        object-fit: cover;
        width: 640px;
        height: 470px;
        border-radius: 12px;
    }

    .thumbnail-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .thumbnail {
        object-fit: cover;
        width: 100px;
        height: 73px;
        border-radius: 12px;
        cursor: pointer;
        transition: 300ms;
    }

    .thumbnail:hover {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        transform: scale(1.03);
    }
    .product-page-data-block h3 {
        margin-top: 15px;
        margin-bottom: 10px;
    }
    .product-page-date {
        font-weight: 400;
        font-size: 14px;
        opacity: 0.6;
        margin-top: 50px;
    }
</style>

<script>
    function updateLargeImage(imagePath) {
        const largeImage = document.getElementById('large-image');
        largeImage.src = imagePath;
    }
</script>
