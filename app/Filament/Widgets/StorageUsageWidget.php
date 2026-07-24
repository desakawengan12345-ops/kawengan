<?php

namespace App\Filament\Widgets;

use App\Models\Destination;
use App\Models\DestinationImage;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\SiteSetting;
use Filament\Widgets\Widget;

class StorageUsageWidget extends Widget
{
    protected static string $view = 'filament.widgets.storage-usage-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 10;

    public function getStorageData(): array
    {
        $settingSize = (int) SiteSetting::whereIn('key', ['hero_image_size'])->sum('value');

        $totalBytes =
            Destination::sum('thumbnail_size') +
            DestinationImage::sum('file_size') +
            Gallery::sum('file_size') +
            Post::sum('thumbnail_size') +
            $settingSize;

        $mb = round($totalBytes / 1024 / 1024, 2);
        $limitMb = 1024; // 1GB
        $percent = min(round(($mb / $limitMb) * 100, 1), 100);

        $color = match(true) {
            $percent >= 90 => 'danger',
            $percent >= 70 => 'warning',
            default => 'success',
        };

        return [
            'mb' => $mb,
            'percent' => $percent,
            'color' => $color,
            'label' => "{$mb} MB / 1 GB",
        ];
    }
}