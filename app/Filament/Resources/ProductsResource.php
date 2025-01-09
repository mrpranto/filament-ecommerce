<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductsResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $cluster = \App\Filament\Clusters\Product::class;

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->maxLength(255)->afterStateUpdated(function ($operation, $state, $set) {
                                        if ($operation == 'create') {
                                            $set('slug', Str::slug($state));
                                        }
                                    })
                                    ->columnSpanFull(),

                                TextInput::make('slug')
                                    ->disabled()
                                    ->required()
                                    ->readonly()
                                    ->unique(Product::class, 'slug', ignoreRecord: true),

                                Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->searchDebounce(0)
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->createOptionForm(Brand::getForm())
                                    ->createOptionModalHeading('Create Brand')
                                    ->editOptionForm(Brand::getForm())
                                    ->editOptionModalHeading('Edit Brand'),

                                RichEditor::make('description')
                                    ->required()
                                    ->columnSpanFull()
                            ])
                            ->columns(2)
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make('Product media')
                            ->schema([
                                FileUpload::make('images')
                                    ->required()
                                    ->multiple()
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),

                        Section::make('Associations')
                            ->schema([
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchDebounce(0)
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->createOptionForm(Category::getForm())
                                    ->createOptionModalHeading('Create Category')
                                    ->editOptionForm(Category::getForm())
                                    ->editOptionModalHeading('Edit Category')
                                    ->afterStateUpdated(function ($operation, $state, $set) {
                                        $set('sub_category_id', null);
                                        $set('sub_sub_category_id', null);
                                    })
                                    ->native(false),

                                Select::make('sub_category_id')
                                    ->relationship('subCategory', 'name', modifyQueryUsing: function (Builder $query, $get): Builder {
                                        return $query->when($get('category_id'), fn($q) => $q->where('category_id', $get('category_id')));
                                    })
                                    ->searchDebounce(0)
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm(SubCategory::getForm())
                                    ->createOptionModalHeading('Create Sub Sub Category')
                                    ->editOptionForm(SubCategory::getForm())
                                    ->afterStateUpdated(function ($operation, $state, $set) {
                                        $set('sub_sub_category_id', null);
                                    })
                                    ->native(false),

                                Select::make('sub_sub_category_id')
                                    ->relationship('subSubCategory', 'name', modifyQueryUsing: function (Builder $query, $get): Builder {
                                        return $query->when($get('sub_category_id'), fn($q) => $q->where('sub_category_id', $get('sub_category_id')));
                                    })
                                    ->searchDebounce(0)
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm(SubSubCategory::getForm())
                                    ->createOptionModalHeading('Create Sub Sub Category')
                                    ->editOptionForm(SubSubCategory::getForm())
                                    ->native(false),
                            ]),

                        Section::make('Status')
                            ->schema([
                                Toggle::make('status')
                                    ->label('Visible')
                                    ->helperText('This product will be hidden from all sale module.')
                                    ->default(true)
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }
}
