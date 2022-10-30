<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-wrap items-center gap-4 justify-start">
            <x-filament::button type="submit">
                Salvar
            </x-filament::button>

            <x-filament::button type="button" color="secondary" tag="a" :href="\Filament\Pages\Dashboard::getUrl()">
                Cancelar
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
