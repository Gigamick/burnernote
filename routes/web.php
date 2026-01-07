<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\NoteController;
use App\Models\Receipt;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $legacyCount = (int) env('LEGACY_BURN_COUNT', 0);
    try {
        $newCount = Receipt::whereIn('status', ['viewed', 'expired'])->count();
    } catch (\Exception $e) {
        $newCount = 0;
    }
    $burnCount = $legacyCount + $newCount;

    return view('welcome', compact('burnCount'));
});

Route::post('/create-note', [NoteController::class, 'create']);
Route::post('/submit-password', [NoteController::class, 'password']);
Route::get('/n/{token}', [NoteController::class, 'show']);
Route::get('/v/{token}', [NoteController::class, 'verify']);

Route::view('/about', 'about');
Route::view('/contact', 'contact');

Route::post('/send-email', [EmailController::class, 'sendemail']);

Route::get('/r/{token}', [NoteController::class, 'receipt']);


