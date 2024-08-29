<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function fetchMessages()
    {
        return response()->json(Message::all());
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create($request->all());

        // 廣播消息
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
