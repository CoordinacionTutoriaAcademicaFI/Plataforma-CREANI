{{-- resources/views/intake/create.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Datos Nuevo Ingreso
    </h2>
  </x-slot>

  @php
      $nombre = auth()->user()->name ?? '';
      $nombre = ucwords(mb_strtolower($nombre,'UTF-8'));
  @endphp

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow sm:rounded-lg p-6 space-y-8">

        {{-- Intro con nombre --}}
        <div class="prose max-w-none">
          <p><strong>¡Bienvenido(a), {{ $nombre }}!</strong></p>
          <p>La Coordinación de Tutoría de la Facultad de Ingeniería te da la cordial bienvenida y reconoce el logro que has alcanzado al ingresar a una ingeniería, carrera que te dará muchas satisfacciones.</p>
          <p>Con la finalidad de acompañarte durante el proceso de inscripción a la Facultad de Ingeniería, por favor, contesta el siguiente cuestionario que tiene la intención de recabar datos de contacto de nuestros alumnos de nuevo ingreso. Esto permitirá a la Coordinación de Tutoría establecer comunicación contigo para informarte de los procesos relacionados a la inscripción y atender tus dudas al respecto.</p>
          <p>Son varios cuestionarios los que deberás contestar. Iniciamos con el cuestionario de datos de contacto y posteriormente se enviarán, a tu correo, otros cuestionarios para valorar tus conocimientos en matemáticas. Es crucial que escribas correctamente tu correo, y teléfono de celular porque serán los medios de comunicación para los siguientes pasos que necesitas realizar en tu proceso de inscripción.</p>
          <p>Si tienes dificultades con contestar esta encuesta, manda Whatsapp a: <strong>7228959749</strong> o chat en la plataforma de Microsoft TEAMS: <strong>tutoria_fi@uaemex.mx</strong></p>
        </div>

        <form method="POST" action="{{ route('intake.store') }}" class="space-y-8">
          @csrf

          {{-- 1 Correo * --}}
          <div>
            <x-input-label for="email_contacto" value="1. Correo *" />
            <x-text-input id="email_contacto" name="email_contacto" type="email" class="mt-1 block w-full"
              :value="old('email_contacto',$form->email_contacto)" required />
            <x-input-error :messages="$errors->get('email_contacto')" class="mt-2" />
          </div>

          <div class="prose max-w-none">
            <p><strong>REVISA QUE INGRESES BIEN TUS DATOS. UNA OMISIÓN DE TU PARTE PUEDE OCASIONAR QUE NO TE LLEGUE LA INFORMACIÓN QUE SE ESTARÁ ENVIANDO</strong></p>
            <p>Sigue las instrucciones, lee con cuidado y contesta lo que se te pide.</p>
          </div>

          {{-- 2 Ingeniería * --}}
          <div>
            <x-input-label for="ingenieria" value="2. Ingeniería a la que ingresaste *" />
            <select id="ingenieria" name="ingenieria" class="mt-1 block w-full rounded-md border-gray-300" required>
              @foreach (config('ingenierias.lista') as $k=>$v)
                <option value="{{ $k }}" @selected(old('ingenieria',$form->ingenieria)===$k)>{{ $v }}</option>
              @endforeach
            </select>
            <x-input-error :messages="$errors->get('ingenieria')" class="mt-2" />
          </div>

          {{-- 3 Promedio (opcional) --}}
          <div>
            <x-input-label for="promedio_bachillerato" value="3. Promedio de Bachillerato (0–10, con decimales). Si no lo tienes, deja en blanco." />
            <x-text-input id="promedio_bachillerato" name="promedio_bachillerato" type="number" step="0.01" min="0" max="10"
              class="mt-1 block w-full max-w-xs" :value="old('promedio_bachillerato',$form->promedio_bachillerato)" />
            <x-input-error :messages="$errors->get('promedio_bachillerato')" class="mt-2" />
          </div>

          {{-- 4–6 (alineados) --}}
          <div class="grid md:grid-cols-3 gap-6 md:items-end">
            <div>
              <x-input-label for="indice_uaem" value="4. Índice UAEM *" />
              <x-text-input id="indice_uaem" name="indice_uaem" type="number" step="0.001" class="mt-1 block w-full"
                :value="old('indice_uaem',$form->indice_uaem)" required />
              <x-input-error :messages="$errors->get('indice_uaem')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="lugar_examen" value="5. Lugar obtenido en el examen de admisión *" />
              <x-text-input id="lugar_examen" name="lugar_examen" type="number" min="1" class="mt-1 block w-full"
                :value="old('lugar_examen',$form->lugar_examen)" required />
              <x-input-error :messages="$errors->get('lugar_examen')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="numero_folio" value="6. Número de folio (9 dígitos, sin letras) *" />
              <x-text-input id="numero_folio" name="numero_folio" type="text" inputmode="numeric" pattern="\d{9}"
                class="mt-1 block w-full" :value="old('numero_folio',$form->numero_folio)" required />
              <x-input-error :messages="$errors->get('numero_folio')" class="mt-2" />
            </div>
          </div>

          {{-- 7–9 --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <x-input-label for="numero_cuenta" value="7. Número de cuenta (7 dígitos, opcional)" />
              <x-text-input id="numero_cuenta" name="numero_cuenta" type="text" inputmode="numeric" pattern="\d{7}"
                class="mt-1 block w-full" :value="old('numero_cuenta',$form->numero_cuenta)" />
              <x-input-error :messages="$errors->get('numero_cuenta')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
              <x-input-label for="facebook_url" value="8. Enlace completo a tu perfil de Facebook (opcional)" />
              <x-text-input id="facebook_url" name="facebook_url" type="url" class="mt-1 block w-full"
                :value="old('facebook_url',$form->facebook_url)" placeholder="https://www.facebook.com/tu.perfil" />
              <x-input-error :messages="$errors->get('facebook_url')" class="mt-2" />
            </div>
          </div>

          <div>
            <x-input-label for="celular" value="9. Número de teléfono de celular *" />
            <x-text-input id="celular" name="celular" type="text" class="mt-1 block w-full max-w-sm"
              :value="old('celular',$form->celular)" required />
            <x-input-error :messages="$errors->get('celular')" class="mt-2" />
          </div>

          {{-- 10–11 radios --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <x-input-label value="10. ¿Tienes servicio de internet en tu casa? *" />
              <div class="mt-2 flex gap-6">
                <label class="inline-flex items-center gap-2">
                  <input type="radio" name="internet_casa" value="1" @checked(old('internet_casa', $form->internet_casa ? '1' : '')==='1') required>
                  <span>Sí</span>
                </label>
                <label class="inline-flex items-center gap-2">
                  <input type="radio" name="internet_casa" value="0" @checked(old('internet_casa', $form->internet_casa===0 ? '0' : '')==='0')>
                  <span>No</span>
                </label>
              </div>
              <x-input-error :messages="$errors->get('internet_casa')" class="mt-2" />
            </div>
            <div>
              <x-input-label value="11. ¿Tienes equipo de cómputo en tu casa? *" />
              <div class="mt-2 flex gap-6">
                <label class="inline-flex items-center gap-2">
                  <input type="radio" name="equipo_computo" value="1" @checked(old('equipo_computo', $form->equipo_computo ? '1' : '')==='1') required>
                  <span>Sí</span>
                </label>
                <label class="inline-flex items-center gap-2">
                  <input type="radio" name="equipo_computo" value="0" @checked(old('equipo_computo', $form->equipo_computo===0 ? '0' : '')==='0')>
                  <span>No</span>
                </label>
              </div>
              <x-input-error :messages="$errors->get('equipo_computo')" class="mt-2" />
            </div>
          </div>

          {{-- 12 Convivencias (multi) + Otro --}}
          <div>
            <x-input-label value="12. ¿Con quién vivirás mientras estudias tu primer semestre? (Selecciona todas las que apliquen)" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2 mt-2">
              @foreach ($convivencias as $c)
                <label class="inline-flex items-center gap-2">
                  <input type="checkbox" name="convivencias[]" value="{{ $c }}" @checked(collect(old('convivencias',$form->convivencias))->contains($c))>
                  <span>{{ $c }}</span>
                </label>
              @endforeach
            </div>
            <div class="mt-3">
              <x-input-label for="convivencia_otro" value="Otro:" />
              <x-text-input id="convivencia_otro" name="convivencia_otro" type="text" class="mt-1 block w-full"
                :value="old('convivencia_otro',$form->convivencia_otro)" />
            </div>
          </div>

          {{-- 13 Tiempo de traslado (radios) --}}
          <div>
            <x-input-label value="13. ¿Cuánto será tu tiempo de traslado de tu casa a la Facultad?" />
            <div class="mt-2 grid sm:grid-cols-2 gap-2">
              @foreach ($traslados as $k=>$v)
                <label class="inline-flex items-center gap-2">
                  <input type="radio" name="tiempo_traslado" value="{{ $k }}" @checked(old('tiempo_traslado',$form->tiempo_traslado)===$k)>
                  <span>{{ $v }}</span>
                </label>
              @endforeach
            </div>
            <x-input-error :messages="$errors->get('tiempo_traslado')" class="mt-2" />
          </div>

          {{-- 14–16 --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <x-input-label for="apellido_paterno" value="14. Escribe tu APELLIDO PATERNO * (MAYÚSCULAS, SIN ACENTOS)" />
              <x-text-input id="apellido_paterno" name="apellido_paterno" type="text" class="mt-1 block w-full"
                :value="old('apellido_paterno',$form->apellido_paterno)" required />
              <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="apellido_materno" value="15. Escribe tu APELLIDO MATERNO * (MAYÚSCULAS, SIN ACENTOS)" />
              <x-text-input id="apellido_materno" name="apellido_materno" type="text" class="mt-1 block w-full"
                :value="old('apellido_materno',$form->apellido_materno)" required />
              <x-input-error :messages="$errors->get('apellido_materno')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="nombres" value="16. Escribe tu(s) NOMBRE(s) * (MAYÚSCULAS, SIN ACENTOS)" />
              <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full"
                :value="old('nombres',$form->nombres)" required />
              <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
            </div>
          </div>

          {{-- 17 Periodo (2026A–2030B) --}}
          <div>
            <x-input-label for="periodo_ingreso" value="17. Periodo de Ingreso *" />
            <select id="periodo_ingreso" name="periodo_ingreso" class="mt-1 block w-full max-w-xs rounded-md border-gray-300" required>
              <option value="">Selecciona…</option>
              @foreach ($periodos as $p)
                <option value="{{ $p }}" @selected(old('periodo_ingreso',$form->periodo_ingreso)===$p)>{{ $p }}</option>
              @endforeach
            </select>
            <x-input-error :messages="$errors->get('periodo_ingreso')" class="mt-2" />
          </div>

          <div class="prose max-w-none">
            <h3>Plataformas que has usado para trabajo en la escuela</h3>
          </div>

          {{-- 18 Plataformas (multi) + Otro --}}
          <div>
            <x-input-label value="18. ¿Cuál de las siguientes plataformas utilizaste para trabajar a distancia? (Selecciona todas las que has usado)" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2 mt-2">
              @foreach ($plataformas as $p)
                <label class="inline-flex items-center gap-2">
                  <input type="checkbox" name="plataformas_usadas[]" value="{{ $p }}" @checked(collect(old('plataformas_usadas',$form->plataformas_usadas))->contains($p))>
                  <span>{{ $p }}</span>
                </label>
              @endforeach
            </div>
            <div class="mt-3">
              <x-input-label for="plataformas_otro" value="Otro:" />
              <x-text-input id="plataformas_otro" name="plataformas_otro" type="text" class="mt-1 block w-full"
                :value="old('plataformas_otro',$form->plataformas_otro)" />
            </div>
            <x-input-error :messages="$errors->get('plataformas_usadas')" class="mt-2" />
          </div>

          {{-- 19 Medios (multi) + Otro --}}
          <div>
            <x-input-label value="19. ¿Cuál fue el medio de comunicación con tus profesores durante la pandemia? (Elige todas las que apliquen)" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2 mt-2">
              @foreach ($medios as $m)
                <label class="inline-flex items-center gap-2">
                  <input type="checkbox" name="medios_comunicacion[]" value="{{ $m }}" @checked(collect(old('medios_comunicacion',$form->medios_comunicacion))->contains($m))>
                  <span>{{ $m }}</span>
                </label>
              @endforeach
            </div>
            <div class="mt-3">
              <x-input-label for="medios_otro" value="Otro:" />
              <x-text-input id="medios_otro" name="medios_otro" type="text" class="mt-1 block w-full"
                :value="old('medios_otro',$form->medios_otro)" />
            </div>
            <x-input-error :messages="$errors->get('medios_comunicacion')" class="mt-2" />
          </div>

          {{-- 20 repetir correo * --}}
          <div>
            <x-input-label for="email_contacto_confirm" value="20. Escribe nuevamente tu correo electrónico *" />
            <x-text-input id="email_contacto_confirm" name="email_contacto_confirm" type="email" class="mt-1 block w-full"
              :value="old('email_contacto_confirm',$form->email_contacto_confirm)" required />
            <x-input-error :messages="$errors->get('email_contacto_confirm')" class="mt-2" />
          </div>

          <div class="prose max-w-none">
            <h3>Correo institucional UAEMéx</h3>
            <p>En caso de no tener, por el momento, correo institucional, no importa. Esta pregunta solo es para identificar quienes ya cuentan con esta información. En caso de no tenerlo se te asignará al iniciar el semestre.</p>
          </div>

          {{-- 21/22 correo institucional --}}
          <div>
            <x-input-label value="21. ¿Tienes correo institucional UAEMéx?" />
            <div class="mt-2 flex gap-6">
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="correo_institucional" value="1" @checked(old('correo_institucional', $form->correo_institucional ? '1' : '')==='1')>
                <span>Sí (si es Sí, escribe el correo abajo)</span>
              </label>
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="correo_institucional" value="0" @checked(old('correo_institucional', $form->correo_institucional===0 ? '0' : '')==='0')>
                <span>No</span>
              </label>
            </div>
            <x-input-label for="uaem_email" value="22. Correo institucional (si ya lo tienes)" class="mt-3" />
            <x-text-input id="uaem_email" name="uaem_email" type="email" class="mt-1 block w-full"
              :value="old('uaem_email',$form->uaem_email)" />
            <x-input-error :messages="$errors->get('uaem_email')" class="mt-2" />
          </div>

          <div class="prose max-w-none">
            <h3>Vulnerabilidad Económica</h3>
          </div>

          {{-- 23 Vulnerabilidad --}}
          <div>
            <x-input-label value="23. Vulnerabilidad económica: sin capacidad de adquirir la canasta básica de bienestar *" />
            <div class="mt-2 flex gap-6">
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="vulnerabilidad_economica" value="1" @checked(old('vulnerabilidad_economica', $form->vulnerabilidad_economica ? '1' : '')==='1') required>
                <span>Sí</span>
              </label>
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="vulnerabilidad_economica" value="0" @checked(old('vulnerabilidad_economica', $form->vulnerabilidad_economica===0 ? '0' : '')==='0')>
                <span>No</span>
              </label>
            </div>
            <x-input-error :messages="$errors->get('vulnerabilidad_economica')" class="mt-2" />
          </div>

          <div class="prose max-w-none">
            <h3>Condición médica</h3>
          </div>

          {{-- 24 Condición médica --}}
          <div>
            <x-input-label value="24. ¿Tienes una situación médica que sea necesaria reportar para tener en cuenta tu caso? *" />
            <div class="mt-2 flex gap-6">
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="condicion_medica" value="1" @checked(old('condicion_medica', $form->condicion_medica ? '1' : '')==='1') required>
                <span>Sí</span>
              </label>
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="condicion_medica" value="0" @checked(old('condicion_medica', $form->condicion_medica===0 ? '0' : '')==='0')>
                <span>No</span>
              </label>
            </div>
            <x-input-error :messages="$errors->get('condicion_medica')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-2">
              En caso afirmativo, envía la documentación de respaldo a <strong>tutoria_fi@uaemex.mx</strong>. Se tratará de manera confidencial.
            </p>
          </div>

          <div class="prose max-w-none">
            <h3>Escuela de Procedencia o Subsistema de Procedencia</h3>
            <p>Elige, de las opciones, la escuela donde estudiaste la preparatoria o el bachillerato. En caso de no encontrar tu escuela, al final de la lista está la opción "Otra", selecciónala y escribe el nombre de tu escuela.</p>
          </div>

          {{-- 25 Escuela + Otro --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <x-input-label for="escuela_procedencia" value="25. Escuela de Procedencia" />
              <select id="escuela_procedencia" name="escuela_procedencia" class="mt-1 block w-full rounded-md border-gray-300">
                <option value="">Selecciona…</option>
                @foreach ($escuelas as $e)
                  <option value="{{ $e }}" @selected(old('escuela_procedencia',$form->escuela_procedencia)===$e)>{{ $e }}</option>
                @endforeach
              </select>
              <x-input-error :messages="$errors->get('escuela_procedencia')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="escuela_procedencia_otro" value="Otro: (especifica el nombre exacto)" />
              <x-text-input id="escuela_procedencia_otro" name="escuela_procedencia_otro" type="text" class="mt-1 block w-full"
                :value="old('escuela_procedencia_otro',$form->escuela_procedencia_otro)" />
              <x-input-error :messages="$errors->get('escuela_procedencia_otro')" class="mt-2" />
            </div>
          </div>

          {{-- Aviso final cuestionarios --}}
          <div class="rounded-lg border border-amber-300 bg-amber-50 p-4">
            <p class="font-semibold">Antes de presionar “Enviar”, lee con atención:</p>
            <ul class="list-disc ml-5 mt-2 text-sm text-gray-800 space-y-1">
              <li>Después de enviar este formulario, deberás contestar <strong>dos cuestionarios</strong> con <strong>2 secciones cada uno</strong> (Álgebra, Trigonometría, Geometría y Cálculo Diferencial).</li>
              <li>Son obligatorios y contienen 8 pequeñas evaluaciones en total. Debes resolver todas.</li>
              <li>Se contestan en un solo momento (no se guardan avances parciales).</li>
              <li>Periodo de entrega: desde que recibas tus resultados hasta la fecha indicada por la Coordinación.</li>
            </ul>
            <p class="mt-3 text-sm">
            </p>
          </div>

          <div class="flex items-center justify-end">
            <x-primary-button>Enviar</x-primary-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
