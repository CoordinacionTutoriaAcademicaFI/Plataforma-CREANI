<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cuestionarios disponibles
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                @forelse ($quizzes as $quiz)
                    <div class="border-b pb-4 last:border-b-0 last:pb-0 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $quiz->titulo }}</h3>
                            <p class="text-sm text-gray-600">{{ $quiz->descripcion }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Vigencia:
                                {{ optional($quiz->inicio_at)->format('d/m/Y H:i') ?? 'sin inicio' }}
                                –
                                {{ optional($quiz->cierre_at)->format('d/m/Y H:i') ?? 'sin cierre' }}
                            </p>
                        </div>
                        <a href="{{ route('quizzes.show', $quiz) }}"
                           class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">
                            Entrar
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No hay cuestionarios abiertos en este momento.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
