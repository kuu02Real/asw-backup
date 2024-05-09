<!-- resources/views/partials/comments.blade.php -->
@php use App\Models\Comment;use App\Models\User;use Carbon\Carbon; @endphp
<head>
    <link href="/resources/css/app.css" rel="stylesheet">
</head>
@if ($comments)
    <div>
        @foreach ($comments as $comment)
            <div wire:key="{{ $comment->id }}" class="m-1 flex">
                <div class="wrapper mt-3">
                    <div class="justify-left items-center text-sm ml-1">
                        <div class="flex text-sm ml-1">
                            <a href="/u/{{ $comment->user->id }}"
                               class="font-light text-sm text-amber-500"> {{ $comment->user->name }} </a>
                            <p class="font-light text-sm ml-1"> replied to </p>
                            <a href="/u/{{ Comment::where('id', $comment->comment_id)->pluck('user_id')->first() }}"
                               class="font-light text-sm ml-1 underline"> {{ User::where('id', Comment::where('id', $comment->comment_id)->pluck('user_id')->first())->pluck('name')->first() }} </a>
                            <p class="font-light text-sm ml-1"> • posted to </p>
                            <a href="/communities/{{$comment->post->community->idComm}}" class="font-light text-sm ml-1 text-amber-800 underline"> {{ $comment->post->community->name }} </a>
                            <p class="font-light text-sm ml-1">• {{ Carbon::now('UTC')->sub($comment->created_at)->diffForHumans() }} </p>
                            @if ($comment->edited)
                                <p class="font-light text-sm ml-1">• (editat) </p>
                            @endif
                        </div>
                        <p class="font-light text-sm ml-1 mt-1"> {{ $comment->content }} </p>
                        <div class="mt-1 flex items-center">
                            <div class="mt-2 flex flex-col items-start h-full justify-between">
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
                                <p class="ml-1 text-sm text-center text-black-400 font-light"> {{ $comment->likes - $comment->dislikes }} </p>
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
            </div>
        @endforeach
    </div>
@endif
