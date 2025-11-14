<?php

declare(strict_types=1);

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): View => view('dashboard'))->middleware('token.valid');
Route::get('/login', fn (): View => view('login'))->name('login');
