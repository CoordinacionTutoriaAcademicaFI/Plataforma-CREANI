<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class QuizController extends Controller
{
    /**
     * Listado de cuestionarios (con buscador y filtro por estado).
     */
    public function index(Request $request)
    {
        $q      = $request->input('q');
        $estado = $request->input('estado'); // borrador | publicado | cerrado | null

        $quizzes = Quiz::query()
            ->when($q, function ($query, $q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('titulo', 'ILIKE', "%{$q}%")
                        ->orWhere('area', 'ILIKE', "%{$q}%")
                        ->orWhere('tema', 'ILIKE', "%{$q}%");
                });
            })
            ->when($estado, function ($query, $estado) {
                if ($estado !== 'todos') {
                    $query->where('estado', $estado);
                }
            })
            ->orderBy('inicio_at', 'desc')
            ->paginate(10) 
            ->withQueryString();  

        return view('admin.quizzes.index', compact('quizzes', 'q', 'estado'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        // Instancia vacía para reutilizar el mismo formulario (_form)
    $quiz = new Quiz([
        'estado' => 'borrador',
    ]);

    return view('admin.quizzes.create', compact('quiz'));
    }

    /**
     * Guarda un nuevo cuestionario.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'area'        => ['required', 'string', 'max:255'],
            'tema'        => ['required', 'string', 'max:255'],
            'inicio_at'   => ['nullable', 'date'],
            'cierre_at'   => ['nullable', 'date', 'after_or_equal:inicio_at'],
        ]);

        // Parsear fechas (vienen como datetime-local)
        $data['inicio_at'] = !empty($data['inicio_at']) ? Carbon::parse($data['inicio_at']) : null;
        $data['cierre_at'] = !empty($data['cierre_at']) ? Carbon::parse($data['cierre_at']) : null;

        $data['estado']     = 'borrador';
        $data['created_by'] = auth()->id();

        Quiz::create($data);

        return redirect()
            ->route('admin.quizzes.index')
            ->with('status', 'quiz-creado');
    }

    /**
     * Mostrar detalle (por ahora simple).
     */
    public function show(Quiz $quiz)
    {
        return view('admin.quizzes.show', compact('quiz'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    /**
     * Actualizar un cuestionario existente.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'titulo'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'area'        => ['required', 'string', 'max:255'],
            'tema'        => ['required', 'string', 'max:255'],
            'inicio_at'   => ['nullable', 'date'],
            'cierre_at'   => ['nullable', 'date', 'after_or_equal:inicio_at'],
            'estado'      => ['required', 'in:borrador,publicado,cerrado'],
        ]);

        $data['inicio_at'] = !empty($data['inicio_at']) ? Carbon::parse($data['inicio_at']) : null;
        $data['cierre_at'] = !empty($data['cierre_at']) ? Carbon::parse($data['cierre_at']) : null;

        $quiz->update($data);

        return redirect()
            ->route('admin.quizzes.index')
            ->with('status', 'quiz-actualizado');
    }

    /**
     * Eliminar cuestionario.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()
            ->route('admin.quizzes.index')
            ->with('status', 'quiz-eliminado');
    }

    /**
     * Publicar cuestionario (cambia a "publicado").
     */
    public function publish(Quiz $quiz)
    {
        $quiz->update([
            'estado'   => 'publicado',
            'inicio_at' => $quiz->inicio_at ?? now(),
        ]);

        return back()->with('status', 'quiz-publicado');
    }

    /**
     * Cerrar cuestionario (cambia a "cerrado").
     */
    public function close(Quiz $quiz)
    {
        $quiz->update([
            'estado'    => 'cerrado',
            'cierre_at' => $quiz->cierre_at ?? now(),
        ]);

        return back()->with('status', 'quiz-cerrado');
    }
}
