<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StudentQuizController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();

        // solo publicados y dentro de fecha
        $quizzes = Quiz::where('estado', 'publicado')
            ->where(function ($q) use ($now) {
                $q->whereNull('inicio_at')->orWhere('inicio_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('cierre_at')->orWhere('cierre_at', '>=', $now);
            })
            ->orderBy('inicio_at', 'desc')
            ->get();

        return view('quizzes.index', compact('quizzes'));
    }

    public function show(Request $request, Quiz $quiz)
{
    // cargamos secciones + preguntas
    $quiz->load([
        'sections' => function ($q) {
            $q->orderBy('orden');
        },
        'sections.questions' => function ($q) {
            $q->orderBy('id');
        },
    ]);

    // para saber si ya tiene intento (OJO: alumno_id, no user_id)
    $attempt = $quiz->attempts()
        ->where('alumno_id', $request->user()->id ?? null)
        ->first();

    return view('quizzes.show', compact('quiz', 'attempt'));
}

}
