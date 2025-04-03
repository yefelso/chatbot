<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', function () {
    return view('chat');
});

Route::match(['GET', 'POST'], '/ask', [ChatBotController::class, 'ask']);
