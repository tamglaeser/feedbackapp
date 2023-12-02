<?php

use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::post('/auth/register', [AuthController::class, 'register']);
//Route::post('/auth/login', [AuthController::class, 'login']);
//
Route::apiResource('feedback', FeedbackController::class);

Route::post('/feedback/upload', [FeedbackController::class, 'uploadFromFile']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
