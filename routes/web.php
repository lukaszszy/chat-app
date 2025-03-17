<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatController;

Route::get('/chat/{id}', [ChatController::class, 'showChat'])->name('chat.show');
Route::get('/chat/{id}/get-history', [ChatController::class, 'getHistory'])->name('chat.history');
Route::get('/chat/{id}/check-survey-status', [ChatController::class, 'checkSurveyStatus'])->name('survey.check');

Route::post('/chat/{id}/store-survey', [ChatController::class, 'storeSurvey'])->name('survey.store');
Route::post('/chat/{id}/send-message', [ChatController::class, 'sendMessage'])->name('chat.message');
Route::post('/chat/{id}/end-chat', [ChatController::class, 'endChat'])->name('chat.end');
Route::post('/chat/{id}/end-survey', [ChatController::class, 'storeEndSurvey'])->name('chat.endSurvey');







