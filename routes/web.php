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

Route::get('/', [\App\Http\Controllers\ChatController::class, 'index'])->name('home');

Route::get('/create-room', [\App\Http\Controllers\ChatController::class, 'findOrCreateRoom'])->name('chat.create-room');

Route::post('/send-message', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send-message');


Route::prefix('profile')->middleware('auth.user')->group(function () {
    Route::get('/{id}', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/{id}/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/update/{id}', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
