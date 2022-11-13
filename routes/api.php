<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['web']], function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/get-token', [AuthController::class, 'get_token']);
});

Route::get('/courses/{id}', [CourseController::class, 'show']);
Route::get('/episodes/{id}', [EpisodeController::class, 'show']);
Route::get('/courses', [CourseController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::get('/your-courses', [CourseController::class, 'your_courses']);
    Route::get('/bought-courses', [CourseController::class, 'bought_courses']);
    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);

    Route::put('/episodes/{id}', [EpisodeController::class, 'update']);
    Route::delete('/episodes/{id}', [EpisodeController::class, 'destroy']);
    Route::post('/episodes/{id}', [EpisodeController::class, 'store']);

    Route::put('cart/buy/{id}', [CartController::class, 'buy_course']);
    Route::get('cart', [CartController::class, 'index']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{course_id}', [CartController::class, 'destroy']);
});

