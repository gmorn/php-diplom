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
    border-radius :12px;
    display: flex;
    align-items: center;
    padding: 0 15px;
    justify-content: space-between;
  }
</style>

<div class="header">
  <div class="icons">
    <img src="{{ asset('image/heart.png') }}" alt="">
    <img src="{{ asset('image/message.png') }}" alt="">
  </div>
  <a href="#" class="title">Web-market</a>
  @guest
  <div class="button-block">
    <a href="{{ route("login") }}">
      @include('components.main-button', ["type" => 'button', "content" => "Войти"])
    </a>
  </div>
  @endguest
  @auth
    <p>{{Auth::user()->name}}</p>
    <a href="{{ route("logout") }}">
      @include('components.main-button', ["type" => 'button', "content" => "Выйти"])
    </a>
    @if(Auth::user()->is_admin)
      <a href="{{ route("admin.panel") }}">      
        @include('components.main-button', ["type" => 'button', "content" => "Админ панель"])
      </a>
    @endif
  @endauth
</div>