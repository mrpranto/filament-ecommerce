<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create Brand')
                ->icon('heroicon-s-plus')
                ->slideOver()
                ->successNotificationTitle('Brand created successfully !')
                ->modalIcon('heroicon-s-plus'),
        ];
    }
}
