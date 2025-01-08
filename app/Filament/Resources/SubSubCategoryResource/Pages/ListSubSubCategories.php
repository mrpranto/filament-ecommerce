<?php

namespace App\Filament\Resources\SubSubCategoryResource\Pages;

use App\Filament\Resources\SubSubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubSubCategories extends ListRecords
{
    protected static string $resource = SubSubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Sub Sub Category')
                ->icon('heroicon-s-plus')
                ->slideOver()
                ->successNotificationTitle('SubSubCategory created successfully !')
                ->modalIcon('heroicon-s-plus')
        ];
    }
}
