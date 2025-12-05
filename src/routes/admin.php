<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;

Route::prefix('admin')->name('admin.')->group(function () {

    // Login administrador (sin middleware)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Rutas protegidas del panel admin
    Route::middleware('admin')->group(function () {

        Route::get('/', function () {
            return redirect()->route('admin.quizzes.index');
        })->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // CRUD básico de cuestionarios
        Route::resource('quizzes', QuizController::class);

        // ➜ Rutas para publicar / cerrar cuestionarios
        Route::patch('/quizzes/{quiz}/publish', [QuizController::class, 'publish'])
            ->name('quizzes.publish');

        Route::patch('/quizzes/{quiz}/close', [QuizController::class, 'close'])
            ->name('quizzes.close');

        // ➜ NUEVAS rutas para gestionar PREGUNTAS de un quiz
        Route::prefix('quizzes/{quiz}')->name('quizzes.')->group(function () {
            Route::get('questions',                 [QuestionController::class, 'index'])->name('questions.index');
            Route::get('questions/create',         [QuestionController::class, 'create'])->name('questions.create');
            Route::post('questions',               [QuestionController::class, 'store'])->name('questions.store');
            Route::get('questions/{question}/edit',[QuestionController::class, 'edit'])->name('questions.edit');
            Route::put('questions/{question}',     [QuestionController::class, 'update'])->name('questions.update');
            Route::delete('questions/{question}',  [QuestionController::class, 'destroy'])->name('questions.destroy');
        });
    });
});
