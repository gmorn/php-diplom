<style>
    .title {
        font-weight: 600;
        font-size: 22px;
    }

    .icons {
        display: flex;
        gap: 15px;
        width: 200px;
    }

    .button-block {
        width: 200px;
        display: flex;
        justify-content: end;
    }

    .header {
        margin-top: 30px;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 0 15px;
        justify-content: space-between;
    }

    .header-user-button {
        display: flex;
        gap: 10px;
        align-items: center;
        padding: 5px 10px;
        border-radius: 12px;
        transition: 300ms;
        cursor: pointer;
        position: relative;
    }

    .header-user-button:hover {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
    }
    .header-user-button img {
        height: 30px;
        width: 30px;
        object-fit: cover;
        border-radius: 100px;
    }

    .header-user-menu {
        position: absolute;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        width: 250px;
        padding: 15px;
        display: flex;
        gap: 5px;
        flex-direction: column;
        top: 45px;
        right: 0;
        border-radius: 12px;
        z-index: 1;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: opacity 0.3s, transform 0.3s, visibility 0.3s;
    }

    .header-user-menu.open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .header-user-menu-item {
        padding: 10px;
        transition: 300ms;
        border-radius: 12px;
    }

    .header-user-menu-item:hover {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        transform: scale(1.02);
    }
</style>

<div class="header">
    <div class="icons">
        <img src="{{ asset('image/header/heart.svg') }}" alt="test">
        <a href="{{route('chat')}}"><img src="{{ asset('image/header/message.svg') }}" alt=""></a>
    </div>
    <a href="{{route('/')}}" class="title">Web-market</a>
    @guest
        <div class="button-block">
            <a href="{{ route("login") }}">
                @include('components.main-button', ["type" => 'button', "content" => "Войти"])
            </a>
        </div>
    @endguest
    @auth
        <div class="header-user-button">
            @if(Auth::user()->images)
                <img src="{{ asset('storage/' . Auth::user()->images) }}" alt="User Avatar">
            @else
                <img src="{{asset('image/header/user-logo.svg')}}" alt="">
            @endif
            <p>{{Auth::user()->name}}</p>
            @if(Auth::user()->is_admin)
                <a href="{{ route("admin.panel") }}">
                    @include('components.main-button', ["type" => 'button', "content" => "Админ панель"])
                </a>
            @endif
            <div class="header-user-menu">
                <a href="{{route('user_products')}}"><p class="header-user-menu-item">Профиль</p></a>
                <a href="{{route('create_product')}}"><p class="header-user-menu-item">Добавить обьявление</p></a>
                <a href="{{route('logout')}}"><p class="header-user-menu-item">Выйти</p></a>
            </div>
        </div>
    @endauth
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userButton = document.querySelector('.header-user-button');
        const userMenu = userButton.querySelector('.header-user-menu');

        userButton.addEventListener('click', function () {
            userMenu.classList.toggle('open');
        });

        document.addEventListener('click', function (event) {
            if (!userButton.contains(event.target)) {
                userMenu.classList.remove('open');
            }
        });
    });
</script>
