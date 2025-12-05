<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $quiz->titulo }}
            </h2>
            @if($attempt)
                <span class="text-sm text-green-700">Intento creado</span>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Aviso / descripción general del cuestionario --}}
            @if($quiz->descripcion)
                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
                    {!! nl2br(e($quiz->descripcion)) !!}
                </div>
            @endif

            {{-- Mostrar puntaje aunque sea 0 --}}
            @if (session()->has('puntaje'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    Cuestionario enviado. Tu puntaje:
                    <strong>{{ session('puntaje') }}</strong>
                </div>
            @endif

            {{-- Si aún no hay intento, mostrar botón de empezar --}}
            @unless($attempt)
                <form method="POST" action="{{ route('quizzes.start', $quiz) }}">
                    @csrf
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                        Empezar cuestionario
                    </button>
                </form>
            @endunless

            @if($attempt)
                @php
                    $attemptFinished = !is_null($attempt->fin_at);
                @endphp

                {{-- SI EL INTENTO YA FUE ENVIADO: SOLO MENSAJE Y BOTÓN AL DASHBOARD --}}
                @if($attemptFinished)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded text-blue-800">
                        Usted ya ha contestado este cuestionario.
                        Solo se permite un intento y sus respuestas han sido registradas.
                        @if(!is_null($attempt->puntaje))
                            <br>
                            Puntaje obtenido: <strong>{{ $attempt->puntaje }}</strong>
                        @endif
                    </div>

                    <div class="text-right mt-4">
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded hover:bg-indigo-700">
                            Volver al dashboard
                        </a>
                    </div>
                @else
                    {{-- INTENTO EN CURSO: MOSTRAR PREGUNTAS Y PERMITIR RESPONDER --}}
                    @foreach ($quiz->sections as $section)
                        <div class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                            <h3 class="text-lg font-semibold">{{ $section->nombre }}</h3>

                            @foreach ($section->questions as $question)
                                <div class="border-t pt-4 mt-4">

                                    {{-- ENUNCIADO --}}
                                    <div class="text-sm">
                                        {!! $question->enunciado_html !!}
                                    </div>

                                    {{-- IMAGEN PRINCIPAL, SI EXISTE --}}
                                    @php
                                        $mainImage = $question->imagen_url ?? null;
                                    @endphp

                                    @if($mainImage)
                                        <div class="mt-3">
                                            <img src="{{ '/storage/'.$mainImage }}"
                                                 alt="Imagen del ejercicio"
                                                 class="max-w-full h-auto">
                                        </div>
                                    @endif

                                    @php
                                        $opciones = (array) ($question->opciones_json ?? []);
                                        $respuestaAlumno = $attempt->answers->firstWhere('question_id', $question->id);
                                        $letters = ['a', 'b', 'c', 'd'];
                                    @endphp

                                    <form method="POST"
                                          action="{{ route('quizzes.answer', [$quiz, $question]) }}"
                                          class="mt-2 space-y-2">
                                        @csrf

                                        @foreach ($opciones as $idx => $op)
                                            @php
                                                $letter    = $letters[$idx] ?? null;
                                                $fieldImg  = $letter ? "option_{$letter}_image" : null;
                                                $imagePath = $fieldImg ? ($question->$fieldImg ?? null) : null;
                                            @endphp

                                            <label class="flex items-center gap-2">
                                                <input
                                                    type="radio"
                                                    name="opcion_idx"
                                                    value="{{ $idx }}"
                                                    @checked(optional($respuestaAlumno)->opcion_idx === $idx)
                                                    onchange="this.form.submit()"
                                                >

                                                @if(!empty($imagePath))
                                                    <img src="{{ '/storage/'.$imagePath }}"
                                                         alt="Opción {{ strtoupper($letter ?? '') }}"
                                                         class="max-h-24">
                                                @else
                                                    <span>{{ $op }}</span>
                                                @endif
                                            </label>
                                        @endforeach

                                        {{-- Botón oculto por si acaso --}}
                                        <button class="hidden mt-2 px-3 py-1 bg-gray-200 rounded text-sm" type="submit">
                                            Guardar respuesta
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    {{-- Botón para ENVIAR/CALIFICAR mientras el intento está en curso --}}
                    <form method="POST"
                          action="{{ route('quizzes.finish', $quiz) }}"
                          class="text-right mt-4"
                          onsubmit="return confirm('¿Seguro que quieres enviar tus respuestas? Después de enviarlas ya no podrás modificar este cuestionario.');">
                        @csrf
                        <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Enviar cuestionario
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
