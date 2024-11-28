<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Bedankt voor het aanmelden! Kunt u, voordat u aan de slag gaat, uw e-mailadres verifiëren door op de link te klikken die we zojuist naar u hebben gemaild? Als u de e-mail niet heeft ontvangen, sturen wij u graag een nieuwe.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('Er is een nieuwe verificatielink verzonden naar het e-mailadres dat u tijdens de registratie heeft opgegeven.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Verificatie-e-mail opnieuw verzenden') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Uit') }}
            </button>
        </form>
    </div>
</x-guest-layout>
