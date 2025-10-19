<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InterviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// 🔹 Rute untuk fitur Interview AI
Route::middleware('auth:sanctum')->group(function () {
Route::post('/generate-questions', [InterviewController::class, 'generateQuestions']);
Route::post('/analyze-answer', [InterviewController::class, 'analyzeAnswer']);
Route::post('/granite-chat', [InterviewController::class, 'generate']);
});
