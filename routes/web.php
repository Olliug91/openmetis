<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard;
use App\Livewire\Config;

Route::get('/login', function () {
    if (session('is_admin')) return redirect('/');
    return view('login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    if ($request->password === env('DASHBOARD_PASSWORD', 'admin')) {
        session(['is_admin' => true]);
        return redirect('/');
    }
    return back()->withErrors(['password' => 'Contraseña incorrecta']);
});

Route::get('/logout', function () {
    session()->forget('is_admin');
    return redirect('/login');
})->name('logout');

Route::middleware([\App\Http\Middleware\ProtectDashboard::class])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/config', function () {
        return view('config');
    })->name('config');
});
