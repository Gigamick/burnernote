<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/create-note', [App\Http\Controllers\NoteController::class, 'create']);
Route::post('/submit-password', [App\Http\Controllers\NoteController::class, 'password']);
Route::get('/n/{token}', [App\Http\Controllers\NoteController::class, 'show']);

