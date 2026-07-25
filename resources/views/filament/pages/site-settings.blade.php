<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Simpan Pengaturan</span>
                    <span wire:loading>Menyimpan...</span>
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>