<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TalentController;
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

Route::middleware('auth')->get('/user', function (Request $request){
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('profile', 'getProfile');
    Route::post('register', 'register');
});

Route::controller(EventController::class)->group(function () {
    Route::post('event', 'create');
    Route::get('events', 'getAll');
    Route::get('event/{id}', 'getByID');
    Route::put('event/{id}', 'update');
    Route::delete('event/{id}', 'delete');
});

Route::controller(TalentController::class)->group(function () {
    Route::post('talent', 'create');
    Route::get('talents', 'getAll');
    Route::get('talent/{id}', 'getById');
    Route::put('talent/{id}', 'update');
    Route::delete('talent/{id}', 'delete');
});