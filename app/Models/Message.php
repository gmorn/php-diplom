<?php

namespace App\Models;

use App\Events\MessageSent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
    ];

    protected $dispatchesEvents = [
        'created' => MessageSent::class,
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
