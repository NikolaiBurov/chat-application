<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/home', [\App\Http\Controllers\ChatController::class, 'index'])->name('home');

Route::get('/create-room', [\App\Http\Controllers\ChatController::class, 'createRoom'])->name('chat.create-room');

Route::post('/send-message', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send-message');
