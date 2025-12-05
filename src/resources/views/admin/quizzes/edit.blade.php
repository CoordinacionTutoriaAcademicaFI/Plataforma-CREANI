<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar cuestionario
      </h2>
      <a href="{{ route('admin.quizzes.index') }}" class="text-indigo-700 hover:underline">Volver</a>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
      @if (session('status'))
        <div class="rounded-md bg-green-50 p-3 text-sm text-green-800">
          {{ session('status') }}
        </div>
      @endif

      <div class="bg-white shadow sm:rounded-lg p-6 space-y-6">
        <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" class="space-y-6">
          @csrf
          @method('PUT')

          @include('admin.quizzes._form', ['quiz' => $quiz])

          <div class="flex items-center justify-between">
            <div class="flex gap-2">
              @if($quiz->estado !== 'publicado')
                <form method="POST" action="{{ route('admin.quizzes.publish', $quiz) }}" onsubmit="return confirm('¿Publicar este cuestionario?')">
                  @csrf @method('PATCH')
                  <button class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Publicar</button>
                </form>
              @endif

              @if($quiz->estado !== 'cerrado')
                <form method="POST" action="{{ route('admin.quizzes.close', $quiz) }}" onsubmit="return confirm('¿Cerrar este cuestionario?')">
                  @csrf @method('PATCH')
                  <button class="px-4 py-2 rounded-md bg-yellow-600 text-white hover:bg-yellow-700">Cerrar</button>
                </form>
              @endif
            </div>

            <div class="flex items-center gap-3">
              <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50">Volver</a>
              <x-primary-button>Guardar cambios</x-primary-button>
            </div>
          </div>
        </form>

        <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}" onsubmit="return confirm('¿Eliminar definitivamente este cuestionario?')" class="mt-4">
          @csrf @method('DELETE')
          <button class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
