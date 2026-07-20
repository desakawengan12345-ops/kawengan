<?php

namespace App\Filament\Resources\DestinationImageResource\Pages;

use App\Filament\Resources\DestinationImageResource;
use Filament\Resources\Pages\EditRecord;

class EditDestinationImage extends EditRecord
{
    protected static string $resource = DestinationImageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}