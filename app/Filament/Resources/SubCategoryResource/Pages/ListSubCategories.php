<?php

namespace App\Filament\Resources\SubCategoryResource\Pages;

use App\Filament\Resources\SubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubCategories extends ListRecords
{
    protected static string $resource = SubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Sub Category')
                ->icon('heroicon-s-plus')
                ->slideOver()
                ->successNotificationTitle('SubCategory created successfully !')
                ->modalIcon('heroicon-s-plus')
        ];
    }
}
