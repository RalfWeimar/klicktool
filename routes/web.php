<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});




Route::resource('clients', App\Http\Controllers\ClientController::class);

Route::resource('contacts', App\Http\Controllers\ContactController::class);

Route::resource('projects', App\Http\Controllers\ProjectController::class);

Route::resource('boxes', App\Http\Controllers\BoxController::class);

Route::resource('mailboxes', App\Http\Controllers\MailboxController::class);
