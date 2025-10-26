<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IntakeFormController;
use App\Models\IntakeForm;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Si ya inició sesión -> dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    // Si no, muestra la landing
    return view('landing'); // resources/views/landing.blade.php
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas autenticadas + verificación de email
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // ÚNICA definición de /dashboard
    Route::get('/dashboard', function () {
        $done = IntakeForm::where('user_id', auth()->id())
            ->whereNotNull('submitted_at')
            ->exists();

        // Si NO ha enviado el formulario, mándalo a llenarlo
        if (!$done) {
            return redirect()->route('intake.create');
        }

        // Si ya lo llenó, muestra el dashboard
        return view('dashboard'); // resources/views/dashboard.blade.php
    })->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Formulario de nuevo ingreso (intake)
    Route::get('/nuevo-ingreso', [IntakeFormController::class, 'create'])->name('intake.create');
    Route::post('/nuevo-ingreso', [IntakeFormController::class, 'store'])->name('intake.store');
});

/*
|--------------------------------------------------------------------------
| Auth (Breeze/Fortify): login, register, verify, etc.
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
