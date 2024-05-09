<x-guest-layout>
    <x-slot name="slot">

        <div class="mt-20 flex justify-center  ">
            <h3 class="p-6 w-4/6 text-2xl">Editar Perfil</h3>
        </div>
        <div class="flex justify-center ">
            <div class="w-4/6 border-4"></div>
        </div>
        <div class="flex justify-center m-4">
            <div class="w-4/6 border-0">
                <form method="post" action="{{route('profile-update')}}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="mb-6">
                        <label for="name" class="text-lg">Nom d'usuari</label>
                        <a class="text-gray-500 text-sm">(max. 20 caràcters)</a>
                        <div class="w-1/4">
                            <input type="text" id="name" name="name" maxlength="20" class="bg-gray-100 border-2 border-blue-400 text-gray-900 text-sm rounded-md w-full m-2 p-2.5" placeholder="{{auth()->user()->name}}" >
                        </div>
                        <div class="text-red-600">
                            <ul>
                                @foreach ($errors->get('name') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="bio" class="text-lg">Biografia</label>
                        <a class="text-gray-500 text-sm">(max. 240 caràcters)</a>
                        <div class="flex w-2/4 h-32 ">
                            <textarea id="bio" name="bio" rows="8" maxlength="240" class="bg-gray-100 resize-none w-full h-full text-sm text-gray-800 m-2 border-2 border-blue-400 rounded-md p-2.5" placeholder="{{auth()->user()->bio}}" ></textarea>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="avatar" class="text-lg">Foto de perfil</label>
                        <img class="rounded-full h-40 w-40 m-2 border-solid border-4 object-cover" src="{{ Storage::disk('s3')->url(auth()->user()->avatar) }}" alt="foto_perfil">
                        <input name="avatar" id="avatar" type="file" class="file:hover:text-white file:hover:bg-blue-700 hover:bg-blue-100 m-2 bg-gray-100 file:bg-blue-200 file:rounded-r-full file:rounded-l-md file:p-2 file:border-0 flex border-solid border-0 rounded-lg  border-blue-600 w-1/3" >
                        <div class="text-red-600">
                            <ul>
                                @foreach ($errors->get('avatar') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="banner" class="text-lg">Banner del perfil</label>
                        <img class="w-4/6 h-48 m-2 object-cover border-solid border-4 rounded-md" src="{{ Storage::disk('s3')->url(auth()->user()->banner) }}" alt="foto_banner">
                        <input type="file" id="banner" name="banner" class="file:hover:text-white file:hover:bg-blue-700 hover:bg-blue-100 m-2 bg-gray-100 file:bg-blue-200 file:rounded-r-full file:rounded-l-md file:p-2 file:border-0 flex border-solid border-0 rounded-lg  border-blue-600 w-1/3" >
                        <div class="text-red-600">
                            <ul>
                                @foreach ($errors->get('banner') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <button type="submit" class="mt-4 p-2 px-4 bg-green-100 text-green-600 hover:text-white hover:bg-green-600 border-green-600 border-solid border-2 rounded-md font-bold">Guardar</button>

                    <a href="{{route('profile')}}">
                        <button class="mx-2 p-2 px-4 bg-red-100 text-red-600 hover:text-white hover:bg-red-600 border-red-600 border-solid border-2 rounded-md font-bold">Tornar al perfil</button>
                    </a>
                </form>
            </div>
        </div>
    </x-slot>
</x-guest-layout>
