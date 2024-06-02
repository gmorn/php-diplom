@php use Illuminate\Support\Facades\Auth; @endphp
@extends('welcome')
@section('title', 'Ваши чаты')
@section('content')
    <div id="auth-user" data-user-id="{{ Auth::id() }}"></div>
    <div class="chat-page-container">
        <div class="chats-list">
            @include('components.main-input', ['placeholder'=>'Поиск', 'name'=>'chat_search', 'type'=>'text'])
            @if($chats->isEmpty())
                <div class="chat-list-message">
                    У вас нет активных чатов.
                </div>
            @else
                    @foreach($chats as $chat)
                    <a href="{{ route('chat', ['id' => $chat->id]) }}">
                        <div class="list-group-item {{ isset($activeChat) && $activeChat->id == $chat->id ? 'active' : '' }}">
                            @php
                                $otherUser = $chat->user_one_id == Auth::user()->id ? $chat->userTwo : $chat->userOne;
                            @endphp
                            @if($otherUser->images)
                                <img class="chat-header-user-image" src="{{ asset('storage/' . $otherUser->images) }}" alt="User Avatar">
                            @else
                                <img class="chat-header-user-image" src="{{asset('image/header/user-logo.svg')}}" alt=""/>
                            @endif

                                Чат с {{ $otherUser->name }}

                        </div>
                    </a>
                    @endforeach
            @endif
        </div>
        <div class="messenger-block">
            @if(isset($activeChat))
                <div class="chat-header">
                    <div class="chat-header-user-data">
                        @if($otherUser->images)
                            <img class="chat-header-user-image" src="{{ asset('storage/' . $otherUser->images) }}" alt="User Avatar">
                        @else
                            <img class="chat-header-user-image" src="{{asset('image/header/user-logo.svg')}}" alt=""/>
                        @endif
                        {{ $otherUser->name }}
                    </div>
                    <img class="chat-header-menu-image" src="{{asset('image/chat/chat-menu.svg')}}" alt="Menu Icon">
                    <div class="chat-header-user-menu">
                        <a href="{{route('user_products')}}"><p class="header-user-menu-item">Удалить чат</p></a>
                    </div>
                </div>
            @endif
            <div class="messages-block" id="messages-block">
                @if($messages->isEmpty())
                    @if(isset($activeChat))
                        <div class="no-messages-message">
                            У вас нет сообщений.
                        </div>
                    @else
                        <div class="no-messages-message">
                            Выберите чат для отображения сообщений.
                        </div>
                    @endif
                @else
                    @foreach($messages as $message)
                        @php
                            $messageClass = $message->sender->id === Auth::user()->id ? 'my-message' : 'other-message';
                        @endphp
                        <div class="message-item {{ $messageClass }}" data-id="{{ $message->id }}">
                            <div class="message">{{ $message->message }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if(isset($activeChat))
                <form action="{{ route('message.store') }}" method="POST" id="message-form" class="chat-send-message-form">
                    @csrf
                    <input type="hidden" name="chat_id" value="{{ $activeChat->id }}">
                    @include('components.main-input', ['placeholder'=>'Введите сообщение', 'name'=>'message', 'type'=>'text'])
                    .<button class="chat-send-message-button" type="submit"><img src="{{asset('image/chat/send.svg')}}" alt="Отправить"></button>
                </form>
            @endif
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.querySelector('.chat-header-menu-image');
        const userMenu = document.querySelector('.chat-header-user-menu');

        menuButton.addEventListener('click', function () {
            userMenu.classList.toggle('open');
        });

        document.addEventListener('click', function (event) {
            if (!menuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.remove('open');
            }
        });
    });

    var lastMessageId = null;

    $(document).ready(function () {
        updateLastMessageId();
        scrollToBottom();

        setInterval(fetchNewMessages, 1000);

        $('#message-form').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.post($(this).attr('action'), formData, function (response) {
                if (response.message) {
                    // Удаление сообщения "У вас нет сообщений", если оно есть
                    $('.no-messages-message').remove();

                    // Добавление сообщения в конец блока
                    addMessage(response.message);

                    // Обновление последнего идентификатора сообщения
                    updateLastMessageId();
                    scrollToBottom();
                }
            }).fail(function (xhr, status, error) {
                console.error('Error:', error);
            });
            $(this).find('input[name="message"]').val('');
        });
    });

    function fetchNewMessages() {
        if (lastMessageId !== null) {
            $.ajax({
                url: '{{ route("get.messages") }}',
                method: 'GET',
                data: {
                    last_message_id: lastMessageId
                },
                success: function (response) {
                    var newMessages = false;
                    response.messages.forEach(function (message) {
                        // Удаление сообщения "У вас нет сообщений", если оно есть
                        $('.no-messages-message').remove();

                        // Добавление сообщения в конец блока, если его еще нет
                        if (!isMessageExist(message.id)) {
                            addMessage(message);
                            newMessages = true;
                        }
                    });
                    if (newMessages) {
                        updateLastMessageId();
                        scrollToBottom();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching new messages:', error);
                }
            });
        }
    }

    function addMessage(message) {
        if (!isMessageExist(message.id)) {
            var messageClass = message.sender.id === {{ Auth::id() }} ? 'my-message' : 'other-message';
            $('#messages-block').append('<div class="message-item ' + messageClass + '" data-id="' + message.id + '"><div class="message">' + message.message + '</div></div>');
        }
    }

    function isMessageExist(messageId) {
        return $('#messages-block .message-item[data-id="' + messageId + '"]').length > 0;
    }

    function updateLastMessageId() {
        var lastMessageElement = $('#messages-block .message-item').last();
        lastMessageId = lastMessageElement.data('id');
    }

    function scrollToBottom() {
        var messagesBlock = $('#messages-block');
        messagesBlock.scrollTop(messagesBlock.prop("scrollHeight"));
    }
</script>

<style>
    .list-group-item {
        margin-top: 15px;
        padding: 10px;
        display: flex;
        gap: 10px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        border-radius: 12px;
    }
    .chat-send-message-form {
        display: flex;
    }
    .chat-send-message-button {
        margin-left: 10px;
        width: 50px;
        border-radius: 12px;
        outline: none;
        cursor: pointer;
        border: none;
        transition: 300ms;
    }
    .chat-send-message-button:hover {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        transform: scale(1.02);
    }

    .chat-header-user-menu {
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

    .chat-header-user-menu.open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .chat-header {
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .chat-header-user-image {
        width: 30px;
        height: 30px;
        border-radius: 50px;
    }

    .chat-header-user-data {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-header-menu-image {
        padding: 5px;
        cursor: pointer;
        border-radius: 12px;
        width: 30px;
        height: 30px;
        transition: 300ms;
    }

    .chat-header-menu-image:hover {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        transform: scale(1.02);
    }

    .no-messages-message {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 500;
    }

    .chat-page-container {
        display: flex;
        align-items: start;
        gap: 15px;
        margin-top: 15px;
    }

    .chats-list {
        min-width: 300px;
        height: 85vh;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 15px;
    }

    .messenger-block {
        width: 100%;
        height: 85vh;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 15px;
        display: flex;
        flex-direction: column;
    }

    .messages-block {
        overflow: hidden;
        height: 100%;
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        padding-top: 10px;
    }

    .messages-block:hover {
        overflow: auto;
    }

    .messages-block::-webkit-scrollbar {
        display: none;
    }

    .messages-block {
        scrollbar-width: none;
    }

    .chat-list-message {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 400;
    }

    .message {
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        margin-bottom: 15px;
    }

    .my-message {
        display: flex;
        margin-left: 10px;
    }

    .my-message .message {
        border-radius: 12px 12px 12px 0;
    }

    .other-message .message {
        border-radius: 12px 12px 0 12px;
    }

    .other-message {
        display: flex;
        justify-content: end;
        margin-right: 10px;
    }
</style>
