<?php

namespace App\Livewire\Posts;

use App\Models\Community;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class EditPost extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Post $post;

    public function mount($post_id): void
    {
        $this->post = new Post();
        if ($post_id) $this->post = Post::findOrFail($post_id);
        $this->form->fill($this->post?->toArray());
    }

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

    public function save(): void
    {
        $data = $this->form->getState();

        $this->post->update($data);

    }

    public function render(): View
    {
        return view('livewire.posts.edit-post')->layout('layouts.guest');
    }
}
