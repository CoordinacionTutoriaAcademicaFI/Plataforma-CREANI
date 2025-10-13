<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        ¡Gracias por registrarte! Antes de continuar, por favor
        verifica tu correo haciendo clic en el enlace que te acabamos de enviar.
        Si no lo recibiste, podemos reenviar otro.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Hemos enviado un nuevo enlace de verificación a tu correo.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                Reenviar correo de verificación
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
