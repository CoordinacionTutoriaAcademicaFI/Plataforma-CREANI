@php
  $estados = ['borrador'=>'Borrador','publicado'=>'Publicado','cerrado'=>'Cerrado'];
  $inicio = old('inicio_at', optional($quiz->inicio_at)->format('Y-m-d\TH:i'));
  $cierre = old('cierre_at', optional($quiz->cierre_at)->format('Y-m-d\TH:i'));
@endphp

<div class="grid md:grid-cols-2 gap-6">
  <div>
    <x-input-label for="titulo" value="Título *" />
    <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full"
      :value="old('titulo', $quiz->titulo)" required />
    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
  </div>

  <div>
    <x-input-label for="estado" value="Estado *" />
    <select id="estado" name="estado" class="mt-1 block w-full rounded-md border-gray-300" required>
      @foreach ($estados as $k=>$v)
        <option value="{{ $k }}" @selected(old('estado',$quiz->estado)===$k)>{{ $v }}</option>
      @endforeach
    </select>
    <x-input-error :messages="$errors->get('estado')" class="mt-2" />
  </div>
</div>

<div>
  <x-input-label for="descripcion" value="Descripción" />
  <textarea id="descripcion" name="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300">{{ old('descripcion', $quiz->descripcion) }}</textarea>
  <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
</div>

<div class="grid md:grid-cols-2 gap-6">
  <div>
    <x-input-label for="area" value="Área *" />
    <x-text-input id="area" name="area" type="text" class="mt-1 block w-full"
      :value="old('area', $quiz->area)" required />
    <x-input-error :messages="$errors->get('area')" class="mt-2" />
  </div>

  <div>
    <x-input-label for="tema" value="Tema *" />
    <x-text-input id="tema" name="tema" type="text" class="mt-1 block w-full"
      :value="old('tema', $quiz->tema)" required />
    <x-input-error :messages="$errors->get('tema')" class="mt-2" />
  </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
  <div>
    <x-input-label for="inicio_at" value="Inicio *" />
    <input id="inicio_at" name="inicio_at" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300"
      value="{{ $inicio }}" required>
    <x-input-error :messages="$errors->get('inicio_at')" class="mt-2" />
  </div>

  <div>
    <x-input-label for="cierre_at" value="Cierre *" />
    <input id="cierre_at" name="cierre_at" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300"
      value="{{ $cierre }}" required>
    <x-input-error :messages="$errors->get('cierre_at')" class="mt-2" />
  </div>
</div>
