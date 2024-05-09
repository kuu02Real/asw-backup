@php use Carbon\Carbon; @endphp
<x-guest-layout>
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalls de la Comunitat</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8 mt-20">
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow-md">
    <h1 class="text-2xl font-bold mb-4">Detalls de la Comunitat</h1>

    @if($community->name)
        <p class="mb-2"><strong>Nom:</strong> {{ $community->name }}</p>
    @endif
    @if ($community->image)
        <div class="mb-4">
            <p class="mt-2"><strong>Icona:</strong> <img src="{{ Storage::disk('s3')->url($community->image) }}"> </p>
        </div>
    @endif

    @if($community->banner)
        <div class="mb-4">
            <p class="mt-2"><strong>Banner:</strong> <img src="{{ Storage::disk('s3')->url($community->banner) }}" alt="Banner de la Comunidad" class="max-w-full h-auto"> </p>
        </div>
    @endif

    <p class="mb-2"><strong>ID de la Comunitat:</strong> {{ $community->idComm }}</p>
</div>
<div class="mb-4">

    <a href="{{ route('community.show', $community->idComm) }}" class="text-yellow-500 hover:underline">Posts</a>

    <a href="{{ route('community.showComments', $community->idComm) }}" class="text-yellow-500 hover:underline">Comentaris</a>

</div>
<div>
    @foreach($comments as $comment)
        <div wire:key="{{ $comment->id }}" class="m-3 flex">
            <div class="justify-center items-center">
                <div class="flex">
                    <a href="/u/{{ $comment->user->id }}" class="font-light text-sm text-amber-500"> {{ $comment->user->name }} </a>
                    <p class="font-light text-sm ml-1">• {{ Carbon::now('UTC')->sub($comment->created_at)->diffForHumans() }} </p>
                    <p class="font-light text-sm ml-1"> • </p>
                    <a href="/post/comments/{{$comment->post->id}}" class="font-light text-sm ml-1 text-green-600 underline"> Anar al post </a>
                    @if ($comment->edited) <p class="font-light text-sm ml-1">• (editat) </p> @endif
                </div>
                <p class="font-light text-sm ml-1 m-2"> {{ $comment->content }} </p>
                {{--  buttons under the content  --}}
                <div class="mt-1 flex items-end">
                    <div class="flex  items-center justify-end">
                        <form action="{{ route('likeComment', ['comment_id' => $comment->id]) }}" method="POST">
                            @csrf
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="w-4 h-4 {{ $comment->hasLiked(auth()->user()) ? 'text-blue-500' : 'text-black' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18"/>
                                </svg>
                            </button>
                        </form>
                        <p class="mb-1 text-sm text-center text-black-400 font-light"> {{ $comment->likes - $comment->dislikes }} </p>
                        <form action="{{ route('dislikeComment', ['comment_id' => $comment->id]) }}" method="POST">
                            @csrf
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="w-4 h-4 {{ $comment->hasDisliked(auth()->user()) ? 'text-red-500' : 'text-black' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <form action="{{ route('comments.store') }}" method="post">
                        @csrf

                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                        <div class="pb-1.5 flex space-x-2 items-center justify-start">
                            {{--funcionalitats de l'autor--}}
                            @if(auth()->id() == $comment->user_id)


                                <form action="{{ route('comments.delete', ['comment_id' => $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="mt-2"
                                            onclick="return confirm('Estas segur de voler esborrar aquest comentari?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </form>

                </div>
            </div>

        </div>
        <hr>
    @endforeach
</div>
</body>



</html>

</x-guest-layout>
