<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Category')
                ->icon('heroicon-s-plus')
                ->slideOver()
                ->successNotificationTitle('Category created successfully !')
                ->modalIcon('heroicon-s-plus'),
        ];
    }
}
