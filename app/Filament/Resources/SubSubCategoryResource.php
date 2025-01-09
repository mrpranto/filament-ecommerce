<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Product;
use App\Filament\Resources\SubSubCategoryResource\Pages;
use App\Filament\Resources\SubSubCategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubSubCategoryResource extends Resource
{
    protected static ?string $model = SubSubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $cluster = Product::class;

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema(SubSubCategory::getForm());
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

                Tables\Columns\ToggleColumn::make('status'),

                Tables\Columns\TextColumn::make('description')
                    ->html()
                    ->limit(100)
                    ->wrap(true)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('createdBy.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updatedBy.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('F j, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('F j, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('sub_category_id')
                    ->form([
                        Forms\Components\Select::make('sub_category_id')
                            ->relationship('subCategory', 'name')
                            ->searchDebounce(0)
                            ->searchable()
                            ->preload()
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(isset($data['sub_category_id']), function (Builder $query) use ($data) {
                                return $query->where('sub_category_id', $data['sub_category_id']);
                            });
                    })
                    ->indicateUsing(function ($data) {
                        if (isset($data['sub_category_id'])) {
                            $subCategory = SubCategory::query()->select(['id', 'name'])->find($data['sub_category_id']);
                            return "Sub Category = {$subCategory->name}";
                        }
                    }),

                Filter::make('status')
                    ->form([
                        Forms\Components\Radio::make('status')
                            ->inline()
                            ->options([
                                '1' => 'Active',
                                '0' => 'Inactive',
                            ])
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(isset($data['status']), function (Builder $query) use ($data) {
                                return $query->where('status', $data['status']);
                            });
                    })
                    ->indicateUsing(function ($data) {
                        if (isset($data['status'])) {
                            $status = $data['status'] === '1' ? 'Active' : 'Inactive';
                            return "Status = {$status}";
                        }
                    }),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('start_date'),
                        Forms\Components\DatePicker::make('end_date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['end_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function ($data) {

                        $string = '';
                        if (isset($data['start_date'])) {
                            $string .= " Start Date = {$data['start_date']}";
                        }
                        if (isset($data['end_date'])) {
                            $string .= " & End Date = {$data['end_date']}";
                        }
                        return $string;

                    })
            ])
            ->filtersTriggerAction(
                fn(Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->slideOver()
                        ->successNotificationTitle('Sub SubCategory updated successfully !')
                        ->modalIcon('heroicon-o-pencil'),

                    Tables\Actions\DeleteAction::make()
                        ->successNotificationTitle('Sub SubCategory deleted successfully !')
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle('Selected Sub SubCategory deleted successfully !'),
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
        ];
    }
}
