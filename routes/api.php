<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTicketCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout');
    Route::post('refresh', 'refresh')->name('refresh');
    Route::post('profile', 'getProfile')->name('profile');
    Route::post('register', 'register')->name('register');
});

Route::controller(EventController::class)->group(function () {
    Route::post('event', 'create')->name('event.create');
    Route::get('events', 'getAll')->name('event.getAll');
    Route::get('event/{id}', 'getByID')->name('event.getByID');
    Route::put('event/{id}', 'update')->name('event.update');
    Route::delete('event/{id}', 'delete')->name('event.delete');
});

Route::controller(EventTicketCategoryController::class)->group(function () {
    Route::post('ticket-category', 'create')->name('ticket-category.create');
    Route::get('event/{event_id}/ticket-categories', 'getByEventId')->name('ticket-category.getByEventId');
    Route::get('ticket-category/{id}', 'getById')->name('ticket-category.getById');
    Route::put('ticket-category/{id}', 'update')->name('ticket-category.update');
    Route::delete('ticket-category/{id}', 'delete')->name('ticket-category.delete');
});

Route::controller(OrderController::class)->group(function () {
    Route::post('order', 'create')->name('order.create');
    Route::get('orders', 'getAll')->name('order.getAll');
    Route::get('user/orders', 'getUserOrders')->name('order.getUserOrders');
});

Route::controller(OrderDetailController::class)->group(function (){
    Route::get('order-detail/{id}', 'getOrderDetail')->name('order-detail.getOrderDetail');
});
