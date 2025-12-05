<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo reactivo – {{ $quiz->titulo }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST"
                      action="{{ route('admin.quizzes.questions.store', $quiz) }}"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @include('admin.questions._form')

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.quizzes.questions.index', $quiz) }}"
                           class="px-4 py-2 text-sm text-gray-600 hover:underline">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                            Guardar pregunta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
