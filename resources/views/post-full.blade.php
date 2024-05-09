@php use Carbon\Carbon; @endphp

<x-guest-layout>
    <x-slot name="slot">
        <link href="/resources/css/app.css" rel="stylesheet">
        <div class="mt-20 max-w-6xl px-6 mx-auto">
            {{--original post--}}
            <div class="m-3 flex">
                <div class="flex flex-col items-center justify-center mr-5">
                    <form action="{{ route('like', ['post_id' => $post->id]) }}" method="POST">
                        @csrf
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6 {{ $post->hasLiked(auth()->user()) ? 'text-blue-500' : 'text-black' }}">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18"/>
                            </svg>
                        </button>
                    </form>
                    <p class="ml-1 text-sm text-center text-black-400 font-light"> {{ $post->likes - $post->dislikes }} </p>
                    <form action="{{ route('disLike', ['post_id' => $post->id]) }}" method="POST">
                        @csrf
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6 {{ $post->hasDisLiked(auth()->user()) ? 'text-red-500' : 'text-black' }}">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3"/>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="justify-center items-center">
                    <h2 href="{{ route('post', ['post_id' => $post->id]) }}" class="font-bold text-lg"> {{ $post->title }} </h2>
                    <div class="flex">
                        <a href="/u/{{ $post->user->id }}" class="font-light text-sm text-amber-500"> {{ $post->user->name }} </a>
                        <p class="font-light text-sm ml-1"> to </p>
                        <a href="/communities/{{$post->community->idComm}}" class="font-light text-sm ml-1 text-amber-800 underline"> {{ $post->community->name }} </a>
                        <p class="font-light text-sm ml-1">• {{ Carbon::now('UTC')->sub($post->created_at)->diffForHumans() }} </p>
                    </div>
                    <div class="flex mt-1">
                        <div class="flex justify-start items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                            </svg>
                            <p class="ml-1 text-sm text-gray-400 font-light"> {{ $post->comments->count() }} </p>
                        </div>
                        <div class="ml-2 flex justify-start items-center">
                            <form method="{{ auth()->user() ? 'POST' : 'GET' }}" action="{{ auth()->user() ? route('save', ['post_id' => $post->id]) : route('login') }}">
                                @csrf
                                <button class="flex items-center" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 {{ $post->hasBeenSaved(auth()->user()) ? 'text-amber-500' : 'text-gray-400' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                        @if(auth()->user()?->id === $post->user_id)
                            <a href="{{ route('edit', ['post_id' => $post->id]) }}" class="ml-2 flex justify-start items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('delete', ['post_id' => $post->id]) }}" class="ml-2 flex justify-start items-center">
                                @csrf
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @if($post->url)
                <div class="flex items-center justify-start mb-2">
                    <p class="font-medium mr-1">Url:</p>
                    <div class="border border-gray-300 rounded-lg p-2">
                        <a href="{{ $post->url }}">{{ $post->url }}</a>
                    </div>
                </div>

            @endif
            @if($post->content)
                <div class="flex items-center justify-start">
                    <p class="font-medium mr-1"></p>
                    <div class="border border-gray-300 rounded-lg p-2">
                        <p> {{ $post->content }} </p>
                    </div>
                </div>
            @endif
            <br>

            {{--create a comment--}}
            @if(auth()->user())
            <form action="{{ route('comments.store')}}" method="post">
                @csrf
                <label for="content" class="p-2"> Afegeix un comentari aqui:</label>
                <textarea name="content" id="content" rows="2" cols ="50" class="border border-gray-300 rounded-lg p-2 m-2 flex" required></textarea>
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Publicar comentari
                </button>
            </form>
            @endif
            <br><hr><br>
            {{--filters--}}
            <div class="flex items-center justify-start">
                <form action="{{ route('indexcomments', ['post_id' => $post->id]) }}" method="GET" id="filterSortForm">
                    @csrf
                    <div class="flex">

                        <div class="ml-5">
                            <select onchange="document.getElementById('filterSortForm').submit()" id="sort" name="sort" class="border border-amber-500 rounded-lg text-sm">
                                <option class="p-2" {{ request('sort') == 'nou' ? 'selected' : '' }} value="nou">
                                    Nou
                                </option>
                                <option class="p-2" {{ request('sort') == 'antic' ? 'selected' : '' }} value="antic">
                                    Antic
                                </option>
                                <option class="p-2" {{ request('sort') == 'popular' ? 'selected' : '' }} value="popular">
                                    Popular
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            {{--show all comments of the post--}}
            @foreach($comments1->whereNull('comment_id') as $comment)
                <div wire:key="{{ $comment->id }}" class="m-3 flex">
                    <div class="justify-center items-center">
                        <div class="flex">
                            <a href="/u/{{ $comment->user->id }}" class="font-light text-sm text-amber-500"> {{ $comment->user->name }} </a>
                            <p class="font-light text-sm ml-1"> to </p>
                            <a href="/communities/{{$comment->post->community->idComm}}" class="font-light text-sm ml-1 text-amber-800 underline"> {{ $comment->post->community->name }} </a>
                            <p class="font-light text-sm ml-1">• {{ Carbon::now('UTC')->sub($comment->created_at)->diffForHumans() }} </p>

                            @if ($comment->edited) <p class="font-light text-sm ml-1">• (editat) </p> @endif
                        </div>
                        <p class="font-light text-sm mt-1"> {{ $comment->content }} </p>

                        <div class="mt-1 flex items-center">
                            {{-- likes and dislikes --}}
                            <div class="flex flex-col items-center justify-start">
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
                                <p class="ml-1 text-md text-center text-black-400 font-light"> {{ $comment->likes - $comment->dislikes }} </p>
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
                            {{--save--}}
                            <div class="flex ml-2 mt-1 justify-start items-center">
                                <form method="{{ auth()->user() ? 'POST' : 'GET' }}" action="{{ auth()->user() ? route('saveComment', ['comment_id' => $comment->id]) : route('login') }}">
                                    @csrf
                                    <button class="flex items-center" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 {{ $comment->hasBeenSaved(auth()->user()) ? 'text-amber-500' : 'text-gray-400' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                            {{--respond--}}
                            <input type="checkbox" id="toggle{{ $comment->id }}" class="toggle-input">
                            <label for="toggle{{ $comment->id }}" class="toggle-button ml-2">
                                <span class="w3-icon" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                </span>
                            </label>

                            <div class="formulario-respuesta ml-2">
                                <form action="{{ route('comments.store') }}" method="post" >
                                    @csrf
                                    <textarea name="content" id="content" rows="2" cols ="50" class="border border-gray-300 rounded-lg p-2 mt-2 flex" required></textarea>
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                    <div class="flex space-x-2 items-center justify-start">
                                        <button class="bg-blue-200 rounded-lg p-1 text-sm ml-2 font-light" type="submit">Comentar</button>
                                    </div>
                                </form>
                            </div>
                            {{--funcionalitats de l'autor--}}
                            @if(auth()->id() == $comment->user_id)
                                {{--edit--}}
                                <form action="{{ route('comments.edit', ['comment_id' => $comment->id]) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="mt-2 ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                    </button>
                                </form>
                                {{--delete--}}
                                <form action="{{ route('comments.delete', ['comment_id' => $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="mt-2 ml-2"
                                            onclick="return confirm('Estas segur de voler esborrar aquest comentari?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                        @include('partials.comments', ['comments' => $comment->replies])
                    </div>

                </div>
                <hr>
            @endforeach
        </div>
    </x-slot>
</x-guest-layout>
