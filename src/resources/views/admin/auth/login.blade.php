<x-guest-layout>
  <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-4">Acceso Administrador</h1>

    @if ($errors->has('auth'))
      <p class="text-red-600 mb-3">{{ $errors->first('auth') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <div class="mb-3">
        <x-input-label for="email" value="Correo" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      value="{{ old('email') }}" required autofocus />
      </div>
      <div class="mb-4">
        <x-input-label for="password" value="Contraseña" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
      </div>
      <x-primary-button>Entrar</x-primary-button>
    </form>
  </div>
</x-guest-layout>
<x-guest-layout>
  <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-4">Acceso Administrador</h1>

    @if ($errors->has('auth'))
      <p class="text-red-600 mb-3">{{ $errors->first('auth') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <div class="mb-3">
        <x-input-label for="email" value="Correo" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      value="{{ old('email') }}" required autofocus />
      </div>
      <div class="mb-4">
        <x-input-label for="password" value="Contraseña" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
      </div>
      <x-primary-button>Entrar</x-primary-button>
    </form>
  </div>
</x-guest-layout>
