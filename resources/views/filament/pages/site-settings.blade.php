<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit" wire:loading.attr="disabled">
                    <x-filament::loading-indicator wire:loading wire:target="save" class="h-4 w-4 me-2" />
                    <span wire:loading>Simpan</span>
                    <span wire:loading.remove wire:target="save">Simpan Pengaturan</span>
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>