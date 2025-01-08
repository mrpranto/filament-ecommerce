<?php

namespace App\Models;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'status',
        'description',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'deleted_at' => 'timestamp',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'sub_category_id' => 'integer',
    ];

    public function subSubCategories(): HasMany
    {
        return $this->hasMany(SubSubCategory::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function getForm(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Select::make('category_id')
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

                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                ]),

            RichEditor::make('description')
                ->columnSpanFull(),

            Toggle::make('status')
                ->default(true)
        ];
    }
}
