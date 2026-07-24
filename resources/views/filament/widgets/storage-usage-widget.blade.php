<x-filament-widgets::widget>
    <x-filament::section>
        @php $data = $this->getStorageData(); @endphp

        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <x-heroicon-o-circle-stack class="w-5 h-5 text-gray-400" />
                <span class="text-sm font-medium" style="color: rgb(156 163 175);">
                    Storage
                </span>
            </div>
            <span class="text-xs text-gray-500 dark:text-gray-400">
                {{ $data['label'] }} &bull; {{ $data['percent'] }}%
            </span>
        </div>

        <div style="width:100%; background:#374151; border-radius:9999px; height:12px; overflow:hidden;">
            <div style="
                height:12px;
                border-radius:9999px;
                width:{{ $data['percent'] }}%;
                background:{{ match ($data['color']) {
    'danger' => '#ef4444',
    'warning' => '#facc15',
    default => '#10b981',
} }};
                transition: width 0.5s ease;
            "></div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>