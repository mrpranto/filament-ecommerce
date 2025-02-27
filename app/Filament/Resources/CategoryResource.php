<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Product;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-c-bolt';
    protected static ?string $cluster = Product::class;

    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form->schema(Category::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit()
                    ->wrap(true)
                    ->html(),
                Tables\Columns\ToggleColumn::make('status'),

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
                        ->successNotificationTitle('Category updated successfully !')
                        ->modalIcon('heroicon-o-pencil'),

                    Tables\Actions\DeleteAction::make()
                        ->successNotificationTitle('Category deleted successfully !')
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle('Selected Category deleted successfully !'),
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
            'index' => Pages\ListCategories::route('/'),
        ];
    }
}
