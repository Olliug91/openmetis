<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard;
use App\Livewire\Config;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/config', function () {
    return view('config');
})->name('config');
