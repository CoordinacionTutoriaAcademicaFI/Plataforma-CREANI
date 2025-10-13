<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Precálculo') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-800">

    <header class="w-full border-b bg-white/80 backdrop-blur-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-semibold text-lg">
                {{ config('app.name', 'Precálculo') }}
            </a>

            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition">
                    Ir al dashboard
                </a>
            @endauth
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-24">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Refuerza tus <span class="text-indigo-600">habilidades de precálculo</span>
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Practica cuestionarios, recibe autocalificación y tareas de refuerzo personalizadas.
                </p>

                @guest
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <!-- Botón: Iniciar sesión -->
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">
                        Iniciar sesión
                    </a>

                    <!-- Botón: Crear cuenta (Registro) -->
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-gray-300 bg-white text-gray-800 font-medium hover:bg-gray-100 transition">
                        Crear cuenta
                    </a>
                </div>
                @else
                <div class="mt-8">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-6 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition">
                        Ir a mi dashboard
                    </a>
                </div>
                @endguest
            </div>

            <div class="relative">
                <div class="aspect-video rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-50 border"></div>
            </div>
        </div>
    </main>

    <footer class="py-8 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} {{ config('app.name', 'Precálculo') }}. Todos los derechos reservados.
    </footer>
</body>
</html>
