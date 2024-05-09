<!-- resources/views/comments/edit.blade.php -->

<x-guest-layout>
    <x-slot name="slot">
        <div class="mt-20 max-w-6xl px-6 mx-auto">
            {{--mostra el contingut al qual estem responent--}}
            @if ($comment->comment_id == null)
                <h1>En resposta al post: <br>{{$comment->post->content}}</h1>
            @else
                <h1>En resposta al comentari: <br>{{$comment->comment->content}}</h1>
            @endif
            <br>
            {{--textarea per afegir el comentari--}}
            <form action="{{ route('comments.update', ['comment_id' => $comment->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="content">Edita el teu comentari:</label>
                    <br>
                    <textarea name="content" id="content" class="form-control" rows="2" cols ="50" style="border:solid 2px blue;" required>{{ $comment->content }}</textarea>
                </div>
                <br>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Publicar comentari
                </button>
            </form>
            <br>
            <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" onclick="javascript:history.back()">Tornar enrere</button>
        </div>
    </x-slot>
</x-guest-layout>
