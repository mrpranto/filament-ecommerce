<?php

namespace App\Models;

use App\Models\Trait\CreatedUpdatedByRelationship;
use App\Models\Trait\ModelBoot;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSubCategory extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedByRelationship, ModelBoot;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sub_category_id',
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
        'sub_category_id' => 'integer',
        'deleted_at' => 'timestamp',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public static function getForm()
    {
        return [
            Select::make('sub_category_id')
                ->relationship('subCategory', 'name')
                ->required()
                ->searchDebounce(0)
                ->searchable()
                ->preload()
                ->createOptionForm(SubCategory::getForm())
                ->createOptionModalHeading('Create Sub Category')
                ->editOptionForm(SubCategory::getForm())
                ->native(false),

            TextInput::make('name')
                ->required()
                ->maxLength(255),

            RichEditor::make('description')
                ->columnSpanFull(),

            Toggle::make('status')
                ->default(true)
        ];
    }
}
