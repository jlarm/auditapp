<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['token.valid']], function () {
    Route::livewire('/', 'pages::dashboard')->name('dashboard');
    Route::livewire('{dealership}', 'pages::dealership')->name('dealership');
    Route::livewire('{dealership}/{store}', 'pages::store')->name('store');
});

Route::livewire('login', 'pages::login')->name('login');
