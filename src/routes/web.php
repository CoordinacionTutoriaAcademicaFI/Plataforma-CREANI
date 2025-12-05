<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IntakeFormController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentQuizController;
use App\Http\Controllers\QuizAttemptController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Si ya inició sesión como ADMIN (login de /admin/login)
    if (session('admin_logged_in')) {
        return redirect()->route('admin.dashboard');
    }

    // Si está autenticado como usuario normal (Breeze)
    if (auth()->check()) {
        return auth()->user()->rol === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }

    // Invitado
    return view('landing'); // resources/views/landing.blade.php
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas autenticadas (alumno) + verificación de email
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard alumno (usa el controlador para mandar $user y $quizzes)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Formulario de nuevo ingreso (intake)
    Route::get('/nuevo-ingreso', [IntakeFormController::class, 'create'])
        ->name('intake.create');
    Route::post('/nuevo-ingreso', [IntakeFormController::class, 'store'])
        ->name('intake.store');

    // Cuestionarios del ALUMNO
    Route::get('/quizzes', [StudentQuizController::class, 'index'])
        ->name('quizzes.index');
    Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])
        ->name('quizzes.show');
    Route::post('/quizzes/{quiz}/start', [QuizAttemptController::class, 'start'])
        ->name('quizzes.start');
    Route::post('/quizzes/{quiz}/questions/{question}', [QuizAttemptController::class, 'answer'])
        ->name('quizzes.answer');
    Route::post('/quizzes/{quiz}/finish', [QuizAttemptController::class, 'finish'])
        ->name('quizzes.finish');
});

/*
|--------------------------------------------------------------------------
| Auth (Breeze) y Admin (panel)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
