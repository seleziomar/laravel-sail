<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logar', [AuthController::class, 'logar']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth']], function(){

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/messages/{room}', [ChatController::class, 'getMessages'])->name('messages.get');
    Route::post('/messages', [ChatController::class, 'storeMessage'])->name('messages.store');
});

