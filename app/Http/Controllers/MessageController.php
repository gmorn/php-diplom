<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'chat_id' => $request->chat_id,
            'sender_id' => Auth::user()->id,
            'message' => $request->message,
        ]);

        return response()->json(['message' => $message->load('sender')]); // Возвращаем сообщение вместе с отправителем
    }

    public function getMessages(Request $request)
    {
        // Определяем идентификатор последнего сообщения на странице
        $lastMessageId = $request->input('last_message_id');

        // Получаем новые сообщения, чьи идентификаторы больше последнего сообщения на странице
        $newMessages = Message::with('sender')
            ->where('id', '>', $lastMessageId)
            ->latest()
            ->take(10)
            ->get();

        // Преобразуем коллекцию сообщений в массивы
        $messagesArray = $newMessages->map(function ($message) {
            return [
                'id' => $message->id,
                'sender' => [
                    'name' => $message->sender->name, // Предполагается, что у вас есть связь с отправителем
                    'id' => $message->sender->id, // Предполагается, что у вас есть связь с отправителем
                ],
                'message' => $message->message,
            ];
        });

        return response()->json(['messages' => $messagesArray]);
    }
}
