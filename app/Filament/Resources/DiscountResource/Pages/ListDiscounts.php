<?php

namespace App\Filament\Resources\DiscountResource\Pages;

use App\Filament\Resources\DiscountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiscounts extends ListRecords
{
    protected static string $resource = DiscountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Discount')
                ->icon('heroicon-s-plus')
                ->slideOver()
                ->successNotificationTitle('Discount created successfully !')
                ->modalIcon('heroicon-s-plus'),
        ];
    }
}
