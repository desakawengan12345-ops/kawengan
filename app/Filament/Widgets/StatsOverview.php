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

            Stat::make('Storage Supabase', $this->getSupabaseStorageUsed())
                ->description('Dari 1GB gratis')
                ->color('info')
                ->icon('heroicon-o-circle-stack'),
        ];
    }

    private function getSupabaseStorageUsed(): string
    {
        try {
            $url = env('SUPABASE_URL') . '/storage/v1/object/list/' . env('SUPABASE_BUCKET', 'kawengan');
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'apikey' => env('SUPABASE_SERVICE_KEY'),
                'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_KEY'),
            ])->post($url, [
                'limit' => 1000,
                'offset' => 0,
                'prefix' => '',
            ]);

            if ($response->successful()) {
                $files = $response->json();
                $totalBytes = collect($files)->sum(fn($file) => $file['metadata']['size'] ?? 0);
                $mb = round($totalBytes / 1024 / 1024, 2);
                $percent = round(($mb / 1024) * 100, 1);
                return "{$mb} MB / 1GB ({$percent}%)";
            }

            return 'Tidak tersedia';
        } catch (\Exception $e) {
            return 'Tidak tersedia';
        }
    }
}
