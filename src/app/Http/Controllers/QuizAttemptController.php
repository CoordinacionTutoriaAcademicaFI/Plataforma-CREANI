<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class QuizAttemptController extends Controller
{
    public function start(Request $request, Quiz $quiz)
    {
        $user = $request->user();

        $attempt = Attempt::firstOrCreate(
            [
                'alumno_id' => $user->id,
                'quiz_id'   => $quiz->id,
            ],
            [
                'inicio_at' => now(),
            ]
        );

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('status', 'intento-creado');
    }

    public function answer(Request $request, Quiz $quiz, Question $question)
    {
        $user = $request->user();

        if ($question->section->quiz_id !== $quiz->id) {
            abort(404);
        }

        $attempt = Attempt::firstOrCreate(
            [
                'alumno_id' => $user->id,
                'quiz_id'   => $quiz->id,
            ],
            [
                'inicio_at' => now(),
            ]
        );

        $data = $request->validate([
            'opcion_idx' => ['required', 'integer', 'min:0'],
        ]);

        $esCorrecta = ((int) $data['opcion_idx'] === (int) $question->correcta_idx);

        // 👉 Para no violar el NOT NULL de tiempo_ms
        $tiempoMs = 0; // si luego quieres calculamos el tiempo real

        Answer::updateOrCreate(
            [
                'attempt_id'  => $attempt->id,
                'question_id' => $question->id,
            ],
            [
                'opcion_idx'  => $data['opcion_idx'],
                'es_correcta' => $esCorrecta,
                'tiempo_ms'   => $tiempoMs,
            ]
        );

        return back()->with('status', 'respuesta-guardada');
    }

    public function finish(Request $request, Quiz $quiz)
    {
        $user = $request->user();

        $attempt = Attempt::where('alumno_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->firstOrFail();

        $quiz->load('sections.questions');

        $totalPreguntas = 0;
        $correctas = 0;

        foreach ($quiz->sections as $section) {
            foreach ($section->questions as $q) {
                $totalPreguntas++;

                $ans = $attempt->answers()
                    ->where('question_id', $q->id)
                    ->first();

                if ($ans && $ans->es_correcta) {
                    $correctas++;
                }
            }
        }

        $puntaje = $totalPreguntas > 0
            ? round(($correctas / $totalPreguntas) * 100, 2)
            : 0;

        $attempt->update([
            'fin_at'  => now(),
            'puntaje' => $puntaje,
        ]);

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('status', 'cuestionario-enviado')
            ->with('puntaje', $puntaje);
    }
}
