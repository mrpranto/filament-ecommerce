<?php

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Resources\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnits extends ListRecords
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create Unit')
                ->icon('heroicon-s-plus')
                ->slideOver()
                ->successNotificationTitle('Unit created successfully !')
                ->modalIcon('heroicon-s-plus'),
        ];
    }
}
