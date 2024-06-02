@extends('user.user-account')
@section('account-content')
    <div class="account-product-container">
        <div class="account-product-container-title">
            <h1>Мои объявления</h1>
            <a href="{{route('create_product')}}">@include('components.main-button', ['type'=>'button', 'content'=>'Добавить объявление'])</a>
        </div>
        <div class="account-products-list">
            @foreach ($products as $product)
                <div class="account-product-list-item">
                    <img class="account-product-image" src="{{ json_decode($product->gallery)[0] }}" alt="">
                    <div class="account-product-content">
                        <div class="account-product-data">
                            <h2>{{$product->name}}</h2>
                            <p>{{$product->price}}₽</p>
                        </div>
                        <div class="account-product-navbar">
                            <a href="{{route('product_edit', $product->id)}}">
                                <div class="account-product-navbar-item">
                                    <img src="{{asset('image/user-account/edit-product.svg')}}" alt="">
                                </div>
                            </a>
                            <div class="account-product-navbar-item">
                                <form action="{{ route('product_delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; padding: 0;">
                                        <img src="{{ asset('image/user-account/trash.svg') }}" alt="">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
<style>
    .account-product-container-title {
        display: flex;
        width: 100%;
        justify-content: space-between;
    }
    .account-product-container {
        padding: 15px;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        width: 920px;
    }
    .account-product-container h1 {
        font-weight: 700;
        font-size: 30px;
        margin-bottom: 15px;
    }
    .account-products-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .account-product-list-item {
        display: flex;
        gap: 10px;
        border-radius: 12px;
        transition: 300ms;
        cursor: pointer;
        overflow: hidden;
    }
    .account-product-list-item:hover {
        transform: scale(1.01);
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
    }
    .account-product-image {
        object-fit: cover;
        min-height: 150px;
        max-height: 150px;
        min-width: 200px;
        max-width: 200px;
    }
    .account-product-content {
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 5px;
    }
    .account-product-content h2 {
        font-weight: 600;
        font-size: 22px;
        margin-bottom: 10px;
    }
    .account-product-content p {
        font-weight: 400;
        font-size: 18px;
        opacity: 0.7;
    }
    .account-product-navbar {
        display: flex;
        padding-top: 5px;
    }
    .account-product-navbar img {
        height: 25px;
        width: 25px;
    }
    .account-product-navbar-item {
        transition: 300ms;
        border-radius: 10px;
        padding: 3px;
        height: 40px;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .account-product-navbar-item:hover {
        transform: scale(1.02);
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
    }
</style>
