<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Procesa el registro.
     */
    public function store(Request $request): RedirectResponse
    {
        // Toma la lista desde config. Aceptamos tanto keys como values por si en Blade usas uno u otro.
        $lista = config('ingenierias.lista', []);
        $permitidas = array_unique(array_merge(array_keys($lista), array_values($lista)));
        $ruleIn = implode(',', $permitidas);

        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'ingenieria'  => ['required', 'string', 'in:' . $ruleIn],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'ingenieria'  => $request->ingenieria,
            'rol'         => 'alumno',   // rol por defecto
            'activo'      => true,       // marcamos activo
            'password'    => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
