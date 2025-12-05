<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cuestionario: {{ $quiz->titulo }} – Preguntas
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.quizzes.index') }}" class="text-sm text-gray-600 hover:underline">
                    ← Volver a cuestionarios
                </a>

                <a href="{{ route('admin.quizzes.questions.create', $quiz) }}"
                   class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                    + Nueva pregunta
                </a>
            </div>

            @if (session('status'))
                <div class="p-3 bg-green-100 text-green-800 text-sm rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Pregunta</th>
                            <th class="px-4 py-2 text-left">Correcta</th>
                            <th class="px-4 py-2 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($questions as $i => $question)
                            @php
                                $opts = $question->opciones_json ?? [];
                                $letters = ['A','B','C','D'];
                                $correctLetter = $letters[$question->correcta_idx] ?? '?';
                            @endphp
                            <tr class="{{ $i % 2 ? 'bg-gray-50' : '' }}">
                                <td class="px-4 py-2 align-top">{{ $i + 1 }}</td>
                                <td class="px-4 py-2 align-top">
                                    {{ Str::limit(strip_tags($question->enunciado_html), 80) }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    {{ $correctLetter }}
                                </td>
                                <td class="px-4 py-2 text-right align-top space-x-2">
                                    <a href="{{ route('admin.quizzes.questions.edit', [$quiz, $question]) }}"
                                       class="text-indigo-600 hover:underline">Editar</a>

                                    <form action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar esta pregunta?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline" type="submit">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    Aún no hay preguntas para este cuestionario.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
