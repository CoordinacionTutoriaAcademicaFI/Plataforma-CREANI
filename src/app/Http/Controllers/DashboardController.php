<?php

namespace App\Http\Controllers;

use App\Models\IntakeForm;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Si por error entra un admin por el login normal, lo mandamos a su panel
        if ($user && $user->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Validar que el alumno ya llenó el formulario de nuevo ingreso
        $done = IntakeForm::where('user_id', $user->id)
            ->whereNotNull('submitted_at')
            ->exists();

        if (! $done) {
            return redirect()->route('intake.create');
        }

        // Quizzes publicados y vigentes
        $now = Carbon::now();

        $quizzes = Quiz::query()
            ->where('estado', 'publicado')
            ->where(function ($q) use ($now) {
                $q->whereNull('inicio_at')
                  ->orWhere('inicio_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('cierre_at')
                  ->orWhere('cierre_at', '>=', $now);
            })
            ->orderBy('inicio_at', 'asc')
            ->get();

        return view('dashboard', [
            'user'    => $user,
            'quizzes' => $quizzes,
        ]);
    }
}
