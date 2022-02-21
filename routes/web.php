<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['reset' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/test', [App\Http\Controllers\HomeController::class, 'index'])->name('test');
Route::get('/ranking', [App\Http\Controllers\RankingController::class, 'index'])->name('ranking.index');;

Route::resource('users', App\Http\Controllers\UserController::class);

Route::resource('tarefas', App\Http\Controllers\TarefasController::class);

Route::resource('cleanRooms', App\Http\Controllers\CleanRoomController::class);

