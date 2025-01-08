<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubSubCategoryResource\Pages;
use App\Filament\Resources\SubSubCategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubSubCategoryResource extends Resource
{
    protected static ?string $model = SubSubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sub_category_id')
                    ->relationship('subCategory', 'name')
                    ->required()
                    ->searchDebounce(0)
                    ->searchable()
                    ->preload()
                    ->createOptionForm(SubCategory::getForm())
                    ->createOptionModalHeading('Create Sub Category')
                    ->editOptionForm(SubCategory::getForm())
                    ->native(false),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

               Forms\Components\Toggle::make('status')
                ->default(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subCategory.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubSubCategories::route('/'),
            'create' => Pages\CreateSubSubCategory::route('/create'),
            'edit' => Pages\EditSubSubCategory::route('/{record}/edit'),
        ];
    }
}
