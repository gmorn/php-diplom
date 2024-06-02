<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat($id = null)
    {
        $user = Auth::user();
        $chats = Chat::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->with(['userOne', 'userTwo', 'messages'])
            ->get();

        $messages = collect();
        $activeChat = null;
        $otherUser = null;

        if ($id) {
            $activeChat = Chat::with('messages')->find($id);
            if ($activeChat) {
                $messages = $activeChat->messages;
                $otherUser = $activeChat->user_one_id == $user->id ? $activeChat->userTwo : $activeChat->userOne;
            }
        }

        return view('chat.chat', compact('chats', 'messages', 'activeChat', 'otherUser'));
    }

    public function createChat(Request $request, $userId)
    {
        $currentUserId = Auth::id();

        // Проверяем, существует ли уже чат между этими пользователями
        $existingChat = Chat::where(function ($query) use ($currentUserId, $userId) {
            $query->where('user_one_id', $currentUserId)
                ->orWhere('user_two_id', $currentUserId);
        })->where(function ($query) use ($userId) {
            $query->where('user_one_id', $userId)
                ->orWhere('user_two_id', $userId);
        })->first();

        if ($existingChat) {
            // Если чат уже существует, перенаправляем на него
            return redirect()->route('chat', ['id' => $existingChat->id]);
        }

        // Создаем новый чат
        $chat = Chat::create([
            'user_one_id' => $currentUserId,
            'user_two_id' => $userId,
        ]);

        // Перенаправляем на страницу чата
        return redirect()->route('chat', ['id' => $chat->id]);
    }
}
