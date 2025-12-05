<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700">
                    Hola {{ $user->name }}, bienvenido 👋
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Aquí verás los cuestionarios que están activos para ti.
                </p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Cuestionarios disponibles</h3>

                @if($quizzes->isEmpty())
                    <p class="text-gray-500 text-sm">
                        Por el momento no hay cuestionarios publicados.
                    </p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($quizzes as $quiz)
                            <li class="py-3 flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $quiz->titulo }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $quiz->descripcion ?? 'Sin descripción' }}
                                    </p>
                                    @if($quiz->inicio_at || $quiz->cierre_at)
                                        <p class="text-xs text-gray-400 mt-1">
                                            @if($quiz->inicio_at)
                                                Desde: {{ $quiz->inicio_at->format('d/m/Y H:i') }}
                                            @endif
                                            @if($quiz->cierre_at)
                                                · Hasta: {{ $quiz->cierre_at->format('d/m/Y H:i') }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('quizzes.show', $quiz) }}"
                                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                                        Resolver
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
