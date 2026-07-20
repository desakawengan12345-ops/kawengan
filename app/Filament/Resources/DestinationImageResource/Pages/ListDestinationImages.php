<?php

namespace App\Filament\Resources\DestinationImageResource\Pages;

use App\Filament\Resources\DestinationImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDestinationImages extends ListRecords
{
    protected static string $resource = DestinationImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
