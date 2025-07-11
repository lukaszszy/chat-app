<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatController;

Route::get('/privacy', function () { return view('privacy'); });

Route::get('/{id}', [ChatController::class, 'showChat'])->name('chat.show');
Route::post('/block-link', [ChatController::class, 'blockLink'])->name('chat.block');
Route::post('/store-survey', [ChatController::class, 'storeSurvey'])->name('chat.store');
Route::get('/{id}/get-history', [ChatController::class, 'getHistory'])->name('chat.history');
Route::post('/{id}/send-message', [ChatController::class, 'sendMessage'])->name('chat.message');
Route::post('/{id}/end-survey', [ChatController::class, 'storeEndSurvey'])->name('chat.endSurvey');







