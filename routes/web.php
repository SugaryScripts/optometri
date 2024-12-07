<?php

use Illuminate\Support\Facades\Route;


Route::get('login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('register', \App\Livewire\Auth\Register::class)->name('register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/', \App\Livewire\Home\Dashboard::class)->name('dashboard');

    Route::get('staff', \App\Livewire\Employee\Staff::class)->name('staff');
    Route::get('user', \App\Livewire\Employee\Users::class)->name('user');

});
