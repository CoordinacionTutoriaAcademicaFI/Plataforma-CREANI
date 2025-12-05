<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cuestionarios
            </h2>
            <a href="{{ route('admin.quizzes.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Nuevo cuestionario
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-md bg-green-50 p-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                {{-- Filtros --}}
                <form method="GET" class="mb-4 grid md:grid-cols-3 gap-3">
                    <div>
                        <x-input-label for="q" value="Buscar" />
                        <x-text-input id="q" name="q" type="text"
                                      class="mt-1 block w-full"
                                      :value="$q"
                                      placeholder="Título/Área/Tema..." />
                    </div>
                    <div>
                        <x-input-label for="estado" value="Estado" />
                        <select id="estado" name="estado"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Todos</option>
                            @foreach (['borrador'=>'Borrador','publicado'=>'Publicado','cerrado'=>'Cerrado'] as $k=>$v)
                                <option value="{{ $k }}" @selected($estado === $k)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <x-primary-button>Filtrar</x-primary-button>
                    </div>
                </form>

                {{-- Tabla --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-600">
                        <tr>
                            <th class="px-2 py-2">Título</th>
                            <th class="px-2 py-2">Área / Tema</th>
                            <th class="px-2 py-2">Inicio</th>
                            <th class="px-2 py-2">Cierre</th>
                            <th class="px-2 py-2">Estado</th>
                            <th class="px-2 py-2 text-right">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y">
                        @forelse ($quizzes as $quiz)
                            <tr>
                                <td class="px-2 py-2 font-medium">{{ $quiz->titulo }}</td>

                                <td class="px-2 py-2">
                                    <div class="text-gray-800">{{ $quiz->area }}</div>
                                    <div class="text-gray-500">{{ $quiz->tema }}</div>
                                </td>

                                <td class="px-2 py-2">
                                    {{ optional($quiz->inicio_at)->format('Y-m-d H:i') }}
                                </td>

                                <td class="px-2 py-2">
                                    {{ optional($quiz->cierre_at)->format('Y-m-d H:i') }}
                                </td>

                                <td class="px-2 py-2">
                                    @php
                                        $colors = [
                                            'borrador'   => 'bg-gray-100 text-gray-800',
                                            'publicado'  => 'bg-green-100 text-green-800',
                                            'cerrado'    => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="px-2 py-0.5 rounded {{ $colors[$quiz->estado] ?? 'bg-gray-100' }}">
                                        {{ ucfirst($quiz->estado) }}
                                    </span>
                                </td>

                                {{-- ACCIONES (reemplazado) --}}
                                <td class="px-2 py-2 text-right">
                                    <div class="flex gap-2 justify-end">
                                        {{-- Botón Preguntas (ahora sí visible) --}}
                                        <a href="{{ route('admin.quizzes.questions.index', $quiz) }}"
                                           class="px-3 py-1 rounded text-white text-xs font-semibold"
                                           style="background:#4b5563;">
                                            Preguntas
                                        </a>

                                        {{-- Botón Editar --}}
                                        <a href="{{ route('admin.quizzes.edit', $quiz) }}"
                                           class="px-3 py-1 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                                            Editar
                                        </a>

                                        {{-- Publicar --}}
                                        @if($quiz->estado !== 'publicado')
                                            <form method="POST" action="{{ route('admin.quizzes.publish', $quiz) }}"
                                                  onsubmit="return confirm('¿Publicar este cuestionario?')">
                                                @csrf
                                                @method('PATCH')
                                                <button class="px-3 py-1 rounded bg-green-600 text-white hover:bg-green-700">
                                                    Publicar
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Cerrar --}}
                                        @if($quiz->estado !== 'cerrado')
                                            <form method="POST" action="{{ route('admin.quizzes.close', $quiz) }}"
                                                  onsubmit="return confirm('¿Cerrar este cuestionario?')">
                                                @csrf
                                                @method('PATCH')
                                                <button class="px-3 py-1 rounded bg-yellow-600 text-white hover:bg-yellow-700">
                                                    Cerrar
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Eliminar --}}
                                        <form method="POST"
                                              action="{{ route('admin.quizzes.destroy', $quiz) }}"
                                              onsubmit="return confirm('¿Eliminar definitivamente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-2 py-6 text-center text-gray-500">
                                    No hay cuestionarios.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-4">
                    {{ $quizzes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
