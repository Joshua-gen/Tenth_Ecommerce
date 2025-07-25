<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::view('dashboard', 'dashboard')->middleware('verified')->name('dashboard');
    Route::view('shop', 'shop')->name('shop'); // Only for 'user' role
    Route::view('cart', 'cart')->name('cart');
    Route::view('sale', 'sale')->name('sale');
});

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/admin/item', 'admin.item')->name('admin.item');
    Route::view('/admin/user', 'admin.user')->name('admin.user');
});

require __DIR__.'/auth.php';
