<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Si el usuario YA inició sesión, mándalo al dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    // Si no, muestra la portada con los dos botones
    return view('landing'); // asegurarte de tener resources/views/landing.blade.php
})->name('home'); // no uses ->middleware('guest') aquí para evitar loops

Route::get('/dashboard', function () {
    return view('dashboard'); // asegurarte de tener resources/views/dashboard.blade.php
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Login, Register, Forgot, Verify Email, etc. (Breeze)
require __DIR__.'/auth.php';
