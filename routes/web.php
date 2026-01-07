<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::post('/create-note', [NoteController::class, 'create']);
Route::post('/submit-password', [NoteController::class, 'password']);
Route::get('/n/{token}', [NoteController::class, 'show']);
Route::get('/v/{token}', [NoteController::class, 'verify']);

Route::view('/about', 'about');
Route::view('/faq', 'faq');
Route::view('/contact', 'contact');

Route::post('/send-email', [EmailController::class, 'sendemail']);


