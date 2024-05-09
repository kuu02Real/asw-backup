@php use Carbon\Carbon; @endphp
<x-guest-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear una nova comunitat</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-6">

<h1 class="text-3xl font-bold mb-6">Create a Community</h1>

<div>
    @if($errors->any())
        <ul class="text-red-500">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
</div>

<form method="post" action="{{ route('community.store') }}" enctype="multipart/form-data" class="max-w-md mx-auto">
    @csrf
    @method('post')

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-600">Name:</label>
        <input type="text" name="name" id="name" placeholder="(opcional)" class="mt-1 p-2 border rounded w-full">
    </div>

    <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-600">Image:</label>
        <input type="file" name="image" id="image" accept="image/*" class="mt-1">
    </div>

    <div class="mb-4">
        <label for="banner" class="block text-sm font-medium text-gray-600">Banner:</label>
        <input type="file" name="banner" id="banner" accept="image/*" class="mt-1">
    </div>

    <div class="mb-4">
        <label for="idComm" class="block text-sm font-medium text-gray-600">Id:</label>
        <input type="text" name="idComm" id="idComm" placeholder="(obligatori)" class="mt-1 p-2 border rounded w-full">
    </div>

    <div class="mb-4">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Save a new community</button>
    </div>
</form>

</body>
</html>
</x-guest-layout>
