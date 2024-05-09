<div class="mt-20 max-w-6xl px-6 mx-auto">
    <form wire:submit="create">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4 text-white bg-amber-500">
            @if(request()->path() === 'crear-post')
                Crear
            @else
                Editar
            @endif

        </x-filament::button>
        <a href="{{ url()->previous() == url()->current() ? route('home') : url()->previous() }}" class="mt-4 rounded-lg p-2 text-sm font-bold text-white bg-red-500">
            Cancel·lar
        </a>
    </form>

    <x-filament-actions::modals />
</div>
