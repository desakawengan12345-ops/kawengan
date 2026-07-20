<?php

namespace App\Filament\Resources\DestinationImageResource\Pages;

use App\Filament\Resources\DestinationImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDestinationImage extends CreateRecord
{
    protected static string $resource = DestinationImageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}