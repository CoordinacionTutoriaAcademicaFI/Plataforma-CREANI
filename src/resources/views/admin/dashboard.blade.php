<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Panel de Administración
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
      @if (session('status'))
        <div class="rounded-md bg-green-50 p-3 text-sm text-green-800">
          {{ session('status') }}
        </div>
      @endif

      <div class="grid md:grid-cols-3 gap-6">
        <a href="{{ route('admin.quizzes.index') }}" class="block bg-white shadow sm:rounded-lg p-6 hover:bg-gray-50">
          <h3 class="font-semibold text-lg">Cuestionarios</h3>
          <p class="text-sm text-gray-600">Crear, programar, publicar/cerrar.</p>
        </a>

        {{-- Espacios para futuras secciones del Admin --}}
        <div class="bg-white shadow sm:rounded-lg p-6 opacity-60">
          <h3 class="font-semibold text-lg">Gestión de Usuarios</h3>
          <p class="text-sm text-gray-600">Asignar grupos a mentores, importar CSV (próximamente).</p>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6 opacity-60">
          <h3 class="font-semibold text-lg">Solicitudes de cambio de grupo</h3>
          <p class="text-sm text-gray-600">Revisar/aprobar con PDF justificante (próximamente).</p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
