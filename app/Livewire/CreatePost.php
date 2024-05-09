<?php

namespace App\Livewire;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreatePost extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Títol')
                    ->required(),
                TextInput::make('url')
                    ->url()
                    ->label('Url'),
                Select::make('community_id')
                    ->label('Comunitat')
                    ->native(false)
                    ->searchable()
                    ->options(
                        Community::all()->pluck('name', 'id')
                    )
                    ->required(),
                MarkdownEditor::make('content')
                    ->label('Contingut')

            ])
            ->statePath('data')
            ->model(Post::class);
    }

    public function create()
    {
        $user = auth()->user();
        $data = $this->form->getState();

        $post = new Post([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $user->id,
            'url' => $data['url'],
            'community_id' =>  $data['community_id'],
            'likes' => 0,
            'dislikes' => 0,
        ]);
        $post->save();

        return redirect(route('home'));
    }

    public function edit($post_id)
    {
        $post = Post::findOrFail($post_id);

        $post->update($this->form->getState());
        $post->save();
    }
    public function mount($post_id = null): void
    {
        $post = collect();
        if ($post_id) $post = Post::findOrFail($post_id);
        $this->form->fill($post?->toArray());
    }

    public function render()
    {
        return view('livewire.create-post')->layout('layouts.guest');
    }
}
