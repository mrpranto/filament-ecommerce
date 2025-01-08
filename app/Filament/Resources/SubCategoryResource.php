<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubCategoryResource\Pages;
use App\Filament\Resources\SubCategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubCategoryResource extends Resource
{
    protected static ?string $model = SubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchDebounce(0)
                    ->searchable()
                    ->preload()
                    ->createOptionForm(Category::getForm())
                    ->createOptionModalHeading('Create Category')
                    ->editOptionForm(Category::getForm())
                    ->editOptionModalHeading('Edit Category')
                    ->native(false),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('status')
                    ->default(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('status'),

                Tables\Columns\TextColumn::make('description')
                    ->limit(100)
                    ->wrap(true)
                    ->html()
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('F j, Y h:i A')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('category_id')
                    ->form([
                        Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchDebounce(0)
                        ->searchable()
                        ->preload()
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(isset($data['category_id']), function (Builder $query) use ($data) {
                                return $query->where('category_id', $data['category_id']);
                            });
                    })
                    ->indicateUsing(function ($data) {
                        if (isset($data['category_id'])) {
                            $category = Category::query()->select(['id', 'name'])->find($data['category_id']);
                            return "Category = {$category->name}";
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
                        ->successNotificationTitle('SubCategory updated successfully !')
                        ->modalIcon('heroicon-o-pencil'),

                    Tables\Actions\DeleteAction::make()
                        ->successNotificationTitle('SubCategory deleted successfully !')
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle('Selected SubCategory deleted successfully !'),
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
            'index' => Pages\ListSubCategories::route('/'),
        ];
    }
}
