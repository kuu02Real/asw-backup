<x-guest-layout>
    <x-slot name="slot">
@auth
    <div class="flex justify-center mt-20 m-4">
        <div class="w-4/6 h-48 ">
            <img class="h-full w-full object-cover border-solid border-4 rounded-md shadow" src="{{ Storage::disk('s3')->url(auth()->user()->banner) }}" alt="banner">
        </div>
    </div>
    <div class="flex justify-center m-4">
        <div class="flex items-start w-4/6">
            <div class="w-1/4 h-48 flex justify-center items-center">
                <img class="rounded-full h-48 w-48 border-solid border-4 object-cover shadow" src="{{ Storage::disk('s3')->url(auth()->user()->avatar) }}">
            </div>
            <div class="w-2/4 m-2">
                <p class="text-2xl font-bold my-3">{{ auth()->user()->name }}</p>
                <p class="my-3 text-gray-600">{{ auth()->user()->email }}</p>
                <p class="my-3 mb-5">{{ auth()->user()->bio }}</p>
                <p class="my-3 text-gray-500 mb-3 flex w-full items-center text-sm font-medium "><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>Membre des del {{ auth()->user()->data_reg }}</p>
                <p class="my-3 flex w-full"><a class="font-bold mr-1">{{count(auth()->user()->posts)}}</a>Posts </p>
                <p class="my-3"><a class="font-bold mr-1">{{count(auth()->user()->comments)}}</a>Comentaris </p>
            </div>
            <div class="w-1/4 h-48 flex justify-end items-start">
                <a href="{{route('profile-edit')}}">
                    <button class="m-4 p-2 px-4 bg-green-100 text-green-600 hover:text-white hover:bg-green-600 border-green-600 border-solid border-2 rounded-full font-bold">Editar perfil</button>
                </a>
                <a href="{{route('logout')}}">

                    <button class="m-4 p-2 bg-red-500 hover:bg-red-600 border-red-600 border-solid border-2 rounded-lg font-bold"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg></button>
                </a>

            </div>
        </div>
    </div>
    {{-- Posts, comentaris, desats --}}
    @yield('content')
    <div class="flex justify-center mt-4 m-4">
        <div class="w-4/6">
            <hr class="border-2">
        </div>
    </div>
    <div class="flex justify-center m-4">
        <div class="w-4/6">
            <div class="flex justify-end items-end">
                @if(auth()->user()->api_token == 'null')
                    <a href="{{route('generate_api_token')}}">
                        <button class="m-4 p-2 px-4 bg-amber-100 text-amber-600 hover:text-white hover:bg-amber-600 border-amber-600 border-solid border-2 rounded-lg font-bold">Generar token API</button>
                    </a>
                @else
                    <p class="my-4 p-2 font-bold"> Api token: </p>
                    <p class="my-4 p-2 px-4 bg-amber-100 text-amber-600 border-amber-600 border-solid border-2 rounded-lg font-bold">{{ auth()->user()->api_token }}</p>
                @endif
            </div>
        </div>
    </div>

@else
    <h2 class="justify-center text-center align-middle font-bold">REGISTRA'T O INICIA SESSIÓ</h2>
@endauth

    </x-slot>
</x-guest-layout>
