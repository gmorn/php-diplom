@extends('welcome')
@section('title', 'Web-Market')
@section('content')
    @include('home.category')
    <div class="home-product-container">
        <h1>Новые объявления</h1>
        <div class="home-products">
            @foreach ($products as $product)
                <a href="{{ route('product', $product->id) }}" class="product-link">
                    <div class="product-card">
                        <img src="{{ json_decode($product->gallery)[0] }}" alt="Product Image">
                        <div class="product-cart-data">
                            <div class="product-cart-top">
                                <div class="product-cart-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
                                <img src="{{asset('image/product-cart/heart-false.svg')}}" alt="">
                            </div>
                            <div class="product-cart-title">{{ $product->name }}</div>
                            <div class="product-cart-bottom">
                                <div class="product-cart-location">{{ $product->address }}</div>
                                <div class="product-cart-date">{{ date('d.m.Y', strtotime($product->created_at)) }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
<style>
    .home-product-container {
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        margin-top: 15px;
        min-height: 250px;
        width: 100%;
        padding: 15px;
    }
    .home-product-container h1 {
        margin-bottom: 15px;
        font-weight: 700;
        font-size: 30px;
    }
    .home-products {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    .product-card {
        border-radius: 12px;
        width: 220px;
        height: 342px;
        text-align: center;
        overflow: hidden;
        cursor: pointer;
        transition: 300ms;
    }
    .product-card:hover {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        transform: scale(1.01);
    }
    .product-card img {
        max-width: 100%;
        width: 220px;
        height: 240px;
        object-fit: cover;
    }
    .product-cart-data {
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: start;
    }
    .product-cart-top{
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
    .product-cart-top img {
        height: 30px;
        width: 30px;
    }
    .product-cart-price {
        font-weight: 600;
        font-size: 22px;
    }
    .product-cart-title {
        font-weight: 500;
        font-size: 14px;
    }
    .product-cart-location {
        font-weight: 500;
        font-size: 14px;
        opacity: 0.5;
    }
    .product-cart-date {
        font-weight: 500;
        font-size: 14px;
        opacity: 0.5;
    }
    .product-cart-bottom {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
</style>
