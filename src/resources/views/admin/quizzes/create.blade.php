<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Nuevo cuestionario
      </h2>
      <a href="{{ route('admin.quizzes.index') }}" class="text-indigo-700 hover:underline">Volver</a>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow sm:rounded-lg p-6 space-y-6">
        <form method="POST" action="{{ route('admin.quizzes.store') }}" class="space-y-6">
          @csrf
          @include('admin.quizzes._form', ['quiz' => $quiz])

          <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50">Cancelar</a>
            <x-primary-button>Crear</x-primary-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
