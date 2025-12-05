@php
    /** @var \App\Models\Question|null $question */
    $qModel = $question ?? null;
    $options = $options ?? ($qModel->opciones_json ?? []);
    $correctLetter = old(
        'respuesta_correcta',
        $correctLetter ?? (isset($qModel)
            ? (['a','b','c','d'][$qModel->correcta_idx] ?? 'a')
            : 'a')
    );
@endphp

@csrf

<div class="space-y-6">
    {{-- Enunciado --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">
            Enunciado de la pregunta
        </label>
        <textarea name="enunciado_html" rows="3"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                  required>{{ old('enunciado_html', $qModel->enunciado_html ?? '') }}</textarea>
        <p class="mt-1 text-xs text-gray-500">
            Puedes escribir el texto del problema. Si necesitas ecuaciones complejas, súbelas en la imagen.
        </p>
    </div>

    {{-- Imagen principal --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">
            Imagen del ejercicio (opcional)
        </label>
        <input type="file" name="imagen"
               class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none">

        @if ($qModel && $qModel->imagen_url)
            <p class="mt-2 text-xs text-gray-500">Imagen actual:</p>
            <img src="{{ asset('storage/'.$qModel->imagen_url) }}" class="mt-1 max-h-48 border rounded">
        @endif
    </div>

    {{-- Opciones A–D --}}
    @php
        $oa = old('opcion_a', $options[0] ?? '');
        $ob = old('opcion_b', $options[1] ?? '');
        $oc = old('opcion_c', $options[2] ?? '');
        $od = old('opcion_d', $options[3] ?? '');
    @endphp

    {{-- Opción A --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Opción A (texto)</label>
            <input type="text" name="opcion_a" value="{{ $oa }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Imagen opción A (opcional)
            </label>
            <input id="option_a_image" name="option_a_image" type="file"
                   accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none">

            @if ($qModel && $qModel->option_a_image)
                <p class="mt-2 text-xs text-gray-500">Imagen actual:</p>
                <img src="{{ asset('storage/'.$qModel->option_a_image) }}"
                     alt="Imagen opción A"
                     class="mt-1 h-16 border rounded">
            @endif
        </div>
    </div>

    {{-- Opción B --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Opción B (texto)</label>
            <input type="text" name="opcion_b" value="{{ $ob }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Imagen opción B (opcional)
            </label>
            <input id="option_b_image" name="option_b_image" type="file"
                   accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none">

            @if ($qModel && $qModel->option_b_image)
                <p class="mt-2 text-xs text-gray-500">Imagen actual:</p>
                <img src="{{ asset('storage/'.$qModel->option_b_image) }}"
                     alt="Imagen opción B"
                     class="mt-1 h-16 border rounded">
            @endif
        </div>
    </div>

    {{-- Opción C --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Opción C (texto)</label>
            <input type="text" name="opcion_c" value="{{ $oc }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Imagen opción C (opcional)
            </label>
            <input id="option_c_image" name="option_c_image" type="file"
                   accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none">

            @if ($qModel && $qModel->option_c_image)
                <p class="mt-2 text-xs text-gray-500">Imagen actual:</p>
                <img src="{{ asset('storage/'.$qModel->option_c_image) }}"
                     alt="Imagen opción C"
                     class="mt-1 h-16 border rounded">
            @endif
        </div>
    </div>

    {{-- Opción D --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Opción D (texto)</label>
            <input type="text" name="opcion_d" value="{{ $od }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Imagen opción D (opcional)
            </label>
            <input id="option_d_image" name="option_d_image" type="file"
                   accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none">

            @if ($qModel && $qModel->option_d_image)
                <p class="mt-2 text-xs text-gray-500">Imagen actual:</p>
                <img src="{{ asset('storage/'.$qModel->option_d_image) }}"
                     alt="Imagen opción D"
                     class="mt-1 h-16 border rounded">
            @endif
        </div>
    </div>

    {{-- Correcta --}}
    <div>
        <span class="block text-sm font-medium text-gray-700 mb-1">
            Respuesta correcta
        </span>
        <div class="flex items-center gap-4 text-sm">
            @foreach (['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $value => $label)
                <label class="inline-flex items-center">
                    <input type="radio" name="respuesta_correcta" value="{{ $value }}"
                           @checked($correctLetter === $value)
                           class="border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-1">Opción {{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div> 

    {{-- Errores --}}
    @if ($errors->any())
        <div class="p-3 bg-red-50 border border-red-200 text-xs text-red-700 rounded">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
