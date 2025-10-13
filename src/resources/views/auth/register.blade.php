<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        {{-- Nombre --}}
        <div>
            <x-input-label for="name" value="Nombre completo" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Ingeniería (solo catálogo) --}}
        <div>
            <x-input-label for="ingenieria" value="Ingeniería" />
            <select id="ingenieria" name="ingenieria" class="mt-1 block w-full rounded-md border-gray-300
                    focus:border-indigo-500 focus:ring-indigo-500">
                <option value="" disabled {{ old('ingenieria') ? '' : 'selected' }}>
                    Selecciona tu ingeniería
                </option>
                @foreach (config('ingenierias.lista') as $key => $label)
                    <option value="{{ $key }}" @selected(old('ingenieria') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('ingenieria')" class="mt-2" />
        </div>

        {{-- Contraseña + Confirmación (una debajo de la otra) --}}
        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" name="password" type="password"
                class="mt-1 block w-full" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Acciones --}}
        <div class="flex items-center justify-end gap-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
               href="{{ route('login') }}">
                ¿Ya tienes cuenta? Inicia sesión
            </a>

            <x-primary-button>
                Registrarse
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
