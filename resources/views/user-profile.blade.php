@php use Carbon\Carbon; @endphp
<x-guest-layout>
    <x-slot name="slot">

            <div class="flex justify-center mt-20 m-4">
                <div class="w-4/6 h-48 ">
                    <img class="h-full w-full object-cover border-solid border-4 rounded-md shadow" src="{{ Storage::disk('s3')->url($user->banner) }}" alt="banner">
                </div>
            </div>
            <div class="flex justify-center m-4">
                <div class="flex items-start w-4/6">
                    <div class="w-1/4 h-48 flex justify-center items-center">
                        <img class="rounded-full h-48 w-48 border-solid border-4 object-cover shadow" src="{{ Storage::disk('s3')->url($user->avatar) }}">
                    </div>
                    <div class="w-2/4 m-2">
                        <p class="text-2xl font-bold my-3">{{ $user->name }}</p>
                        <p class="my-3 text-gray-600">{{ $user->email }}</p>
                        <p class="my-3 mb-5">{{ $user->bio }}</p>
                        <p class="my-3 text-gray-500 mb-3 flex w-full items-center text-sm font-medium "><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>Membre des del {{ $user->data_reg }}</p>
                        <p class="my-3 flex w-full"><a class="font-bold mr-1">{{count($user->posts)}}</a>Posts </p>
                        <p class="my-3"><a class="font-bold mr-1">{{count($user->comments)}}</a>Comentaris </p>
                    </div>
                    <div class="w-1/4 h-48 flex justify-end items-start">
                        @if($user->id == auth()->user()?->id)
                        <a href="{{route('profile-edit')}}">
                            <button class="m-4 p-2 px-4 bg-green-100 text-green-600 hover:text-white hover:bg-green-600 border-green-600 border-solid border-2 rounded-full font-bold">Editar perfil</button>
                        </a>
                        <a href="{{route('logout')}}">

                            <button class="m-4 p-2 bg-red-500 hover:bg-red-600 border-red-600 border-solid border-2 rounded-lg font-bold"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg></button>
                        </a>
                        @endif

                    </div>
                </div>
            </div>
                @if($user->id == auth()->user()?->id)
                <div class="flex justify-center m-4 "><ul class="grid w-4/6  md:grid-cols-3 ">
                @else
                <div class="flex justify-center m-4 "><ul class="grid w-4/6  md:grid-cols-2 ">
                @endif
                        <li>
                            @if($type == 'posts')
                                <input checked type="radio" id="posts" name="hosting" value="posts" class="hidden peer" >
                            @else
                                <input onclick="location.href='/u/{{$user->id}}/posts';" type="radio" id="posts" name="hosting" value="posts" class="hidden peer" >
                            @endif
                                <label for="posts" class="shadow inline-flex items-center w-full p-4 text-gray-500 bg-white rounded-tl-lg border-b border-b-gray-200 peer-checked:border-b-4 peer-checked:border-b-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-blue-600 ">
                                    <div class=" justify-center w-full text-lg font-semibold flex items-end">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" />
                                        </svg>
                                        Posts
                                    </div>
                                </label>
                        </li>
                        <li>
                            @if($type == 'comentaris')
                                <input checked  type="radio" id="comentaris" name="hosting" value="comentaris" class="hidden peer" >
                                @else
                            <input onclick="location.href='/u/{{$user->id}}/comentaris';" type="radio" id="comentaris" name="hosting" value="comentaris" class="hidden peer" >
                            @endif
                            <label for="comentaris" class="shadow justify-center inline-flex items-center w-full p-4 text-gray-500 bg-white border-b  border-gray-200 peer-checked:border-b-4 peer-checked:border-b-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-b-blue-600">
                                <div class="">
                                    <div class="w-full text-lg font-semibold flex items-end">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                        </svg>
                                        Comentaris
                                    </div>
                                </div>
                            </label>
                        </li>
                        @if($user->id == auth()->user()?->id)
                        <li>
                            @if($type == 'desats')
                                <input  checked type="radio" id="desats" name="hosting" value="desats" class="hidden peer" >
                            @else
                                <input onclick="location.href='/u/{{$user->id}}/desats';" type="radio" id="desats" name="hosting" value="desats" class="hidden peer" >
                            @endif
                            <label for="desats" class="shadow justify-center inline-flex items-center w-full p-4 text-gray-500 bg-white border-b border-gray-200 peer-checked:border-b-4 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-blue-600">
                                <div class="">
                                    <div class="w-full text-lg font-semibold flex items-end ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                        </svg>
                                        Desats
                                    </div>
                                </div>
                            </label>
                        </li>
                        @endif
                    </ul>
                </div>
                @if($type=='posts' and count($content) == 0)

                    <div class="justify-center flex">
                        <div class="w-4/6 grid grid-rows-4 m-4  ">
                            <a class="font-medium text-lg items-center justify-center flex w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">
                                Encara no s'ha fet cap post
                            </a>
                            <a class="w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">
                            </a>
                            <a class="w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">
                            </a>
                            <a class="w-full border-2 rounded-lg bg-gray-100 h-32 my-2">
                            </a>
                            <a class="w-full border-2 rounded-lg bg-gray-100 h-32 my-2">
                            </a>
                        </div>
                    </div>
                @elseif($type=='posts' and !empty($content))
                    <div class="justify-center flex">
                        <div class="w-4/6 m-4">
                            @foreach($content as $post)
                                <div wire:key="{{ $post->id }}" class="m-4 flex">
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

                                        <p> {{ $post->likes - $post->dislikes }} </p>
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
                                        <a href="{{ route('indexcomments', ['post_id' => $post->id]) }}" class="font-bold text-lg"> {{ $post->title }} </a>
                                        @if($post->url)
                                            <div class="font-light text-sm text-blue-500">
                                                <a href="{{ $post->url }}">{{ $post->url }}</a>
                                            </div>
                                        @endif
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

                                        {{--                        <p> {{ $post->content }} </p>--}}
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                @endif
        @if($type=='comentaris' and count($content) == 0)
            <div class="justify-center flex">
                <div class="w-4/6 grid grid-rows-4 m-4  ">
                    <a class="font-medium text-lg items-center justify-center flex w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">
                        Encara no s'ha fet cap comentari
                    </a>
                    <a class="w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">

                    </a>
                    <a class="w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">

                    </a>
                    <a class="w-full border-2 rounded-lg bg-gray-100 h-32 my-2">

                    </a>
                    <a class="w-full border-2 rounded-lg bg-gray-100 h-32 my-2">
                    </a>
                </div>
            </div>
            @elseif($type =='comentaris' and !empty($content))
                <div class="justify-center flex">
                    <div class="w-4/6 grid  ">
                        @foreach($content as $comment)
                            <div wire:key="{{ $comment->id }}" class="m-3 flex">
                                <div class="justify-center items-center">
                                    <div class="flex">
                                        <a href="/u/{{ $comment->user->id }}" class="font-light text-sm text-amber-500"> {{ $comment->user->name }} </a>
                                        <p class="font-light text-sm ml-1"> to </p>
                                        <a href="/communities/{{$comment->post->community->idComm}}" class="font-light text-sm ml-1 text-amber-800 underline"> {{ $comment->post->community->name }} </a>
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
                </div>
            @endif
        @if($type=='desats' and count($content) == 0)
            <div class="justify-center flex">
                <div class="w-4/6 grid grid-rows-4 m-4  ">
                    <a class="font-medium text-lg items-center justify-center flex w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">
                        Encara no s'ha desat res
                    </a>
                    <a class="w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">
                    </a>
                    <a class="w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">
                    </a>
                    <a class="w-full border-2 rounded-lg bg-gray-100 h-32 my-2">
                    </a>
                    <a class="w-full border-2 rounded-lg bg-gray-100 h-32 my-2">
                    </a>
                </div>
            </div>
        @elseif($type=='desats' and !empty($content))
            <div class="justify-center flex">
                <div class="w-4/6 m-4">
                    @foreach($content as $post)
                        <div wire:key="{{ $post->id }}" class="m-4 flex">
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

                                <p> {{ $post->likes - $post->dislikes }} </p>
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
                                <a href="{{ route('indexcomments', ['post_id' => $post->id]) }}" class="font-bold text-lg"> {{ $post->title }} </a>
                                @if($post->url)
                                    <div class="font-light text-sm text-blue-500">
                                        <a href="{{ $post->url }}">{{ $post->url }}</a>
                                    </div>
                                @endif
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

                                {{--                        <p> {{ $post->content }} </p>--}}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        @endif


    </x-slot>
</x-guest-layout>
