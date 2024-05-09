<x-guest-layout>
    <x-slot name="slot">

    <section class="bg-gray-50 ">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <img class="w-64 h-39  drop-shadow-lg " src="{{ asset('images/tapalogo.png') }}" alt="logo">

            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl  text-center">
                        Inicia sessió o Registra't
                    </h1>
                    <a
                        class="mb-3 flex w-full items-center justify-center"
                        href="{{ route('login-google') }}">
                        <button class="border-blue-500 rounded-full border-4 p-4 drop-shadow-lg hover:bg-fuchsia-500 hover:border-solid hover:bg-opacity-20 hover:border-fuchsia-500">
                            <img class="h-24" src="https://fonts.gstatic.com/s/i/productlogos/googleg/v6/24px.svg" alt="google logo">
                        </button>
                    </a>
                </div>
            </div>
            <img class="w-64  h-12  drop-shadow-lg" src="{{ asset('images/platlogo.png') }}" alt="logo">
        </div>
    </section>
    </x-slot>
</x-guest-layout>
