<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @filamentStyles
    @livewireStyles
    @vite('resources/css/app.css')
</head>
<body>
<header class="fixed z-50 top-0 w-screen bg-white shadow">
    <div class="flex items-center py-4 px-6 max-w-6xl mx-auto">
        <div class="flex items-center mr-8">
            <img class="object-scale-down h-8 w-8 mr-1" src="{{ asset('images/logotincgana.png') }}" alt="">
            <a href="/" class="inline-flex items-center justify-center py-2 bg-white border border-transparent rounded-md font-bold text-sm text-black hover:text-amber-500 hover:underline-offset-2 tracking-widest focus:outline-none">
                TincGana
            </a>
        </div>
        <div class="flex-grow hidden md:block">
            <nav>
                <a href="/communities" class="inline-flex items-center justify-center px-2 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-black hover:text-amber-500 hover:underline-offset-2 uppercase tracking-widest focus:outline-none">
                    Comunitats
                </a>
                <a href="{{ auth()->user() ? '/crear-post' : '/login' }}" id="b" class="inline-flex items-center justify-center px-2 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-black hover:text-amber-500 hover:underline-offset-2 uppercase tracking-widest focus:outline-none">
                    Crear post
                </a>
            </nav>
        </div>
        <div class="px-4 relative mx-auto text-gray-600">
            <form method="get" action="{{url('/cerca')}}">
                @csrf
            <label for="search"></label>
            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                   type="search" id="search" name="search" placeholder="Cerca">
            <button type="submit" class="absolute right-0 top-0 mt-2 mr-6">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-600 h-5 w-5 ">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>

            </button>
            </form>
        </div>
        <div class="ml-auto relative flex">
            @auth
                <a href="{{route('profile')}}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-black hover:text-amber-500 hover:underline-offset-2 uppercase tracking-widest focus:outline-none">
                    {{auth()->user()->name}}
                </a>
                <a href="{{route('profile')}}" class="inline-flex items-center justify-center border rounded-full bg-white ">
                    <img class="rounded-full h-8 w-8  object-cover" src="{{ Storage::disk('s3')->url(auth()->user()->avatar) }}">
                </a>
            @else
                <a href="{{route('login')}}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-black hover:text-amber-500 hover:underline-offset-2 uppercase tracking-widest focus:outline-none">
                    Inicia sessió
                </a>
                <a href="{{route('login')}}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-black hover:text-amber-500 hover:underline-offset-2 uppercase tracking-widest focus:outline-none">
                    Registra't
                </a>
            @endauth
        </div>
    </div>
</header>


{{ $slot }}

@filamentScripts
@livewireScriptConfig
@vite('resources/js/app.js')
</body>
</html>

