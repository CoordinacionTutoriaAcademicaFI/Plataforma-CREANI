<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Section;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Lista todas las preguntas de un cuestionario.
     */
    public function index(Quiz $quiz)
    {
        // cargamos secciones + preguntas
        $quiz->load(['sections.questions']);

        // aplanamos todas las preguntas en una colección
        $questions = $quiz->sections->flatMap->questions;

        return view('admin.questions.index', compact('quiz', 'questions'));
    }

    /**
     * Formulario para crear una pregunta.
     */
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }

    /**
     * Guarda una nueva pregunta con imagen + opciones.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'enunciado_html'      => ['required', 'string'],
            'opcion_a'            => ['required', 'string'],
            'opcion_b'            => ['required', 'string'],
            'opcion_c'            => ['required', 'string'],
            'opcion_d'            => ['required', 'string'],
            'respuesta_correcta'  => ['required', 'in:a,b,c,d'],
            'dificultad'          => ['nullable', 'integer', 'min:1', 'max:5'],
            'imagen'              => ['nullable', 'image', 'max:2048'], // imagen principal

            // imágenes por opción (opcionales)
            'option_a_image'      => ['nullable', 'image', 'max:2048'],
            'option_b_image'      => ['nullable', 'image', 'max:2048'],
            'option_c_image'      => ['nullable', 'image', 'max:2048'],
            'option_d_image'      => ['nullable', 'image', 'max:2048'],
        ]);

        // Opciones A–D guardadas como arreglo en JSON
        $opciones = [
            $data['opcion_a'],
            $data['opcion_b'],
            $data['opcion_c'],
            $data['opcion_d'],
        ];

        // letra -> índice (0,1,2,3)
        $map = ['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3];
        $correctIdx = $map[$data['respuesta_correcta']];

        // Imagen principal (opcional)
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('questions', 'public');
        }

        // Imágenes por opción
        $optionImages = [];
        foreach (['a', 'b', 'c', 'd'] as $letter) {
            $field = "option_{$letter}_image";
            if ($request->hasFile($field)) {
                $optionImages[$field] = $request->file($field)->store("questions/options", 'public');
            }
        }

        // Usamos una sección por defecto (Sección 1) para no complicar
        $section = $quiz->sections()->orderBy('orden')->first();
        if (!$section) {
            $section = $quiz->sections()->create([
                'nombre'       => 'Sección 1',
                'orden'        => 1,
                'ponderacion'  => 100,
            ]);
        }

        Question::create([
            'section_id'     => $section->id,
            'enunciado_html' => $data['enunciado_html'],

            // solo usamos la columna que EXISTE en la DB
            'imagen_url'     => $imagenPath,

            'opciones_json'  => $opciones,
            'correcta_idx'   => $correctIdx,
            'dificultad'     => $data['dificultad'] ?? 1,

            // imágenes por opción
            'option_a_image' => $optionImages['option_a_image'] ?? null,
            'option_b_image' => $optionImages['option_b_image'] ?? null,
            'option_c_image' => $optionImages['option_c_image'] ?? null,
            'option_d_image' => $optionImages['option_d_image'] ?? null,
        ]);

        return redirect()
            ->route('admin.quizzes.questions.index', $quiz)
            ->with('status', 'pregunta-creada');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Quiz $quiz, Question $question)
    {
        // seguridad: que la pregunta pertenezca al quiz
        if ($question->section->quiz_id !== $quiz->id) {
            abort(404);
        }

        $options = $question->opciones_json ?? [];
        $letters = ['a', 'b', 'c', 'd'];
        $correctLetter = $letters[$question->correcta_idx] ?? 'a';

        return view('admin.questions.edit', [
            'quiz'          => $quiz,
            'question'      => $question,
            'options'       => $options,
            'correctLetter' => $correctLetter,
        ]);
    }

    /**
     * Actualiza una pregunta.
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        if ($question->section->quiz_id !== $quiz->id) {
            abort(404);
        }

        $data = $request->validate([
            'enunciado_html'      => ['required', 'string'],
            'opcion_a'            => ['required', 'string'],
            'opcion_b'            => ['required', 'string'],
            'opcion_c'            => ['required', 'string'],
            'opcion_d'            => ['required', 'string'],
            'respuesta_correcta'  => ['required', 'in:a,b,c,d'],
            'dificultad'          => ['nullable', 'integer', 'min:1', 'max:5'],
            'imagen'              => ['nullable', 'image', 'max:2048'],

            // imágenes por opción (opcionales)
            'option_a_image'      => ['nullable', 'image', 'max:2048'],
            'option_b_image'      => ['nullable', 'image', 'max:2048'],
            'option_c_image'      => ['nullable', 'image', 'max:2048'],
            'option_d_image'      => ['nullable', 'image', 'max:2048'],
        ]);

        $opciones = [
            $data['opcion_a'],
            $data['opcion_b'],
            $data['opcion_c'],
            $data['opcion_d'],
        ];

        $map = ['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3];
        $correctIdx = $map[$data['respuesta_correcta']];

        // Imagen principal actual (solo usamos imagen_url)
        $imagenPath = $question->imagen_url;

        if ($request->hasFile('imagen')) {
            if ($imagenPath) {
                Storage::disk('public')->delete($imagenPath);
            }
            $imagenPath = $request->file('imagen')->store('questions', 'public');
        }

        // Partimos de las imágenes actuales por opción
        $optionImages = [
            'option_a_image' => $question->option_a_image,
            'option_b_image' => $question->option_b_image,
            'option_c_image' => $question->option_c_image,
            'option_d_image' => $question->option_d_image,
        ];

        // Imágenes por opción (actualización)
        foreach (['a', 'b', 'c', 'd'] as $letter) {
            $field = "option_{$letter}_image";

            if ($request->hasFile($field)) {
                // si ya había imagen, la eliminamos
                if (!empty($question->$field)) {
                    Storage::disk('public')->delete($question->$field);
                }

                $optionImages[$field] = $request->file($field)->store("questions/options", 'public');
            }
        }

        $question->update([
            'enunciado_html' => $data['enunciado_html'],

            // seguimos usando SOLO imagen_url
            'imagen_url'     => $imagenPath,

            'opciones_json'  => $opciones,
            'correcta_idx'   => $correctIdx,
            'dificultad'     => $data['dificultad'] ?? 1,

            // imágenes por opción
            'option_a_image' => $optionImages['option_a_image'],
            'option_b_image' => $optionImages['option_b_image'],
            'option_c_image' => $optionImages['option_c_image'],
            'option_d_image' => $optionImages['option_d_image'],
        ]);

        return redirect()
            ->route('admin.quizzes.questions.index', $quiz)
            ->with('status', 'pregunta-actualizada');
    }

    /**
     * Elimina la pregunta.
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        if ($question->section->quiz_id !== $quiz->id) {
            abort(404);
        }

        $pathsToDelete = [];

        // imagen principal
        if ($question->imagen_url) {
            $pathsToDelete[] = $question->imagen_url;
        }

        // borrar imágenes por opción
        foreach (['option_a_image', 'option_b_image', 'option_c_image', 'option_d_image'] as $field) {
            if (!empty($question->$field)) {
                $pathsToDelete[] = $question->$field;
            }
        }

        foreach (array_unique($pathsToDelete) as $path) {
            Storage::disk('public')->delete($path);
        }

        $question->delete();

        return redirect()
            ->route('admin.quizzes.questions.index', $quiz)
            ->with('status', 'pregunta-eliminada');
    }
}
