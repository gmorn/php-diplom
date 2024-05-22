@extends('welcome')
@section('title', 'Web-Market')
@section('content')
<div class="home-navbar">
  <div class="category-button">
    <img src="{{ asset('image/category-menu.png') }}" alt="">
    <p>Категории</p>
  </div>
  <div class="search-input">
    <input placeholder="Искать" type="text">
    <img  src="{{ asset('image/search.png') }}" alt="">
  </div>
</div>
<div class="home-category">
  <div class="home-category-block">
    <img src="{{ asset('image/category/image 60.jpg') }}" alt="">
    <div class="home-category-title home-caterory-title-1">
      Транспорт
    </div>
  </div>
  <div class="home-category-block home-category-block-big">
    <img src="{{ asset('image/category/image 61.jpg') }}" alt="">
    <div class="home-category-title home-caterory-title-2">
      Недвижимость
    </div>
  </div>
  <div class="home-category-block">
    <img src="{{ asset('image/category/image 55.jpg') }}" alt="">
    <div class="home-category-title home-caterory-title-3">
      Хобби и отдых
    </div>
  </div>
  <div class="home-category-block home-category-block-big">
    <img src="{{ asset('image/category/image 54.jpg') }}" alt="">
    <div class="home-category-title home-caterory-title-4">
      Электроника
    </div>
  </div>
  <div class="home-category-block home-category-block-big">
    <img src="{{ asset('image/category/image 56.jpg') }}" alt="">
    <div class="home-category-title home-caterory-title-5">
      Оборудование
    </div>
  </div>
  <div class="home-category-block">
    <img src="{{ asset('image/category/image 57.jpg') }}" alt="">
    <div class="home-category-title home-caterory-title-6">
      Животные
    </div>
  </div>
  <div class="home-category-block home-category-block-big">
    <img src="{{ asset('image/category/image 53.jpg') }}" alt="">
    <div class="home-category-title home-caterory-title-7">
      Для дома и дачи
    </div>
  </div>
  <div class="home-category-block">
    <img src="{{ asset('image/category/image 52.jpg') }}" alt="">
    <div class="home-category-title home-caterory-title-8">
      Личные вещи
    </div>
  </div>
</div>
@endsection
<style>
  .home-category {
    min-width: 1250px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    padding: 15px;
    box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
    border-radius: 12px; 
  }

  .home-category-block {
    overflow: hidden;
    border-radius: 12px;
    position: relative;
    transition: 300ms;
    cursor: pointer;
  }

  .home-category-block:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
  }


  .home-category-block-big {
    width: 327px;
  }
  
  .home-category-title {
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 12px;
  }

  .home-caterory-title-1 {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }

    .home-caterory-title-2 {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }

    .home-caterory-title-3 {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }

    .home-caterory-title-4 {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }

    .home-caterory-title-5 {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }

    .home-caterory-title-6 {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }

    .home-caterory-title-7 {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }

    .home-caterory-title-8 {
    position: absolute;
    bottom: 15px;
    right: 15px;
  }


  .home-navbar {
    display: flex;
    gap: 15px;
    margin: 15px 0;
  }

  .category-button {
    display: flex;
    gap: 15px;
    align-items: center;
    height: 50px;
    padding: 0 10px;
    box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    cursor: pointer;
  }

  .search-input {
    width: 100%;
    display: flex;
    align-items: center;
  }

  .search-input img {
    margin-left: -55px;
  }

  .search-input input {
    display: flex;
    align-items: center;
    height: 50px;
    padding: 0 15px;
    box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    border: none;
    outline: none;
    font-size: 16px;
    width: 100%;
  }

  .category-section {

  }
</style>