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

    Route::get('catalog', \App\Livewire\Home\Catalog::class)->name('catalog');
    Route::get('catalog/{hashed}', \App\Livewire\Home\CatalogDetail::class)->name('catalog.detail');

    Route::prefix('product-management')->group(function () {
        Route::get('brand', \App\Livewire\ProductManagement\Brand::class)->name('brand');
        Route::get('brand/form/{hashed?}', \App\Livewire\ProductManagement\BrandEditor::class)->name('brand.form');
        Route::get('type', \App\Livewire\ProductManagement\Type::class)->name('type');
        Route::get('product', \App\Livewire\ProductManagement\Product::class)->name('product');
    });

});
