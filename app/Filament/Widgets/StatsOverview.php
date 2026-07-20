<?php

namespace App\Filament\Widgets;

use App\Models\Destination;
use App\Models\DestinationImage;
use App\Models\Gallery;
use App\Models\SiteSetting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $settings = SiteSetting::whereIn('key', [
            'hero_title',
            'hero_subtitle',
            'about_title',
            'about_content',
            'history_title',
            'history_content',
            'contact_phone',
            'contact_address',
        ])->pluck('value', 'key');

        $settingStatus = collect($settings)->every(fn($value) => !empty($value))
            ? 'Lengkap ✓'
            : 'Belum ✗';

        return [
            Stat::make('Destinasi Wisata', Destination::count())
                ->description(Destination::where('is_published', true)->count() . ' ditampilkan')
                ->color('success')
                ->icon('heroicon-o-map-pin'),

            Stat::make('Foto Destinasi', DestinationImage::count())
                ->description('Total foto di semua destinasi')
                ->color('info')
                ->icon('heroicon-o-camera'),

            Stat::make('Foto Galeri', Gallery::count())
                ->description('Total foto di galeri desa')
                ->color('warning')
                ->icon('heroicon-o-film'),

            Stat::make('Pengaturan Website', $settingStatus)
                ->description('Hero & kontak')
                ->color($settingStatus === 'Sudah dikonfigurasi' ? 'success' : 'danger')
                ->icon('heroicon-o-cog-6-tooth'),
        ];
    }
}
