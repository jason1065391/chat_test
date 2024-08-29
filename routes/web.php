<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\MessageController;

Route::get('/messages', [MessageController::class, 'fetchMessages']);
Route::post('/send-message', [MessageController::class, 'sendMessage']);

// 這個路由處理顯示聊天頁面
Route::get('/chat', function () {
    return view('chat'); // 請確保這個視圖文件存在
});