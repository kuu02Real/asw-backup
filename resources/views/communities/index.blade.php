<x-guest-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Communities</title>
    @vite('resources/css/app.css')
</head>




<body class="bg-gray-100 p-8 flex items-center justify-center min-h-screen">
<div class="overflow-x-auto">
    <h1 class="text-2xl font-bold mb-4">Communities</h1>
    <div class="mb-4">
        @if(auth()->check())
            <a href="{{ route('community.listsubscribed') }}" class="text-yellow-500 hover:underline">Subscrites</a>
        @else
            <a href="{{ route('login') }}" class="text-yellow-500 hover:underline">Subscrites</a>
        @endif
        <a href="{{ route('community.index') }}" class="text-yellow-500 hover:underline">Local</a>
    </div>

    <div class="mb-4">
        <a href="{{ route('community.create') }}" class="inline-block bg-yellow-500 text-white py-2 px-4 rounded">Create a new community</a>
    </div>

    <table class="min-w-full border border-gray-300 bg-center">
        <thead>
        <tr>
            <th class="py-2 px-4 border-b">NAME</th>
            <th class="py-2 px-4 border-b">ID</th>
            <th class="py-2 px-4 border-b">#Publicacions</th>
            <th class="py-2 px-4 border-b">#Comentaris</th>
            <th class="py-2 px-4 border-b">Subscriure's!</th>
        </tr>
        </thead>
        <tbody>
        @foreach($communities as $community)
            <tr>
                <td class="py-2 px-4 border-b">
                    @if($community->name)
                    <a href="{{ route('community.show', $community->idComm) }}" class="text-black-500 hover:underline">{{ $community->name }}</a>
                    @else
                        <a href="{{ route('community.show', $community->idComm) }}" class="text-black-500 hover:underline">{{ $community->idComm }}</a>
                    @endif
                </td>
                <td class="py-2 px-4 border-b">{{ $community->idComm }}</td>
                <td class="py-2 px-4 border-b">{{ $community->posts->count() }}</td>
                <td class="py-2 px-4 border-b">{{ $community->through('posts')->has('comments')->count()}}</td>
                <td class="py-2 px-4 border-b">
                    @if(auth()->check())
                        @if(auth()->user()->communities->contains($community))
                            <a href="{{ route('community.subscribe', $community->idComm) }}" class="text-yellow-500 hover:underline">Desuscriure's</a>
                        @else
                        <a href="{{ route('community.subscribe', $community->idComm) }}" class="text-yellow-500 hover:underline">Subscriut-hi!</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-yellow-500 hover:underline">Subscriut-hi!</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
</x-guest-layout>
