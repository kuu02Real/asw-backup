@php use Carbon\Carbon; @endphp
@extends('layouts.profilelayout')
@section('content')
    <div class="flex justify-center m-4 ">
        <ul class="grid w-4/6  md:grid-cols-3 ">
            <li>

                    <input onclick="location.href='/dashboard/posts';" type="radio" id="posts" name="hosting" value="posts" class="hidden peer" >
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
                <input checked type="radio" id="comentaris" name="hosting" value="comentaris" class="hidden peer" >
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
            <li>
                <input onclick="location.href='/dashboard/desats';" type="radio" id="desats" name="hosting" value="desats" class="hidden peer" >
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
        </ul>
    </div>
@if(count($comentaris)==0)

    <div class="justify-center flex">
        <div class="w-4/6 grid grid-rows-4 m-4  ">
            <a class="font-medium text-lg items-center justify-center flex w-full border-2 rounded-lg bg-gray-100 my-2 h-32 ">
                Encara no has fet cap comentari
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

@else
    <div class="justify-center flex">
        <div class="w-4/6 m-4">
            @foreach($comentaris as $comment)
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
@endsection
