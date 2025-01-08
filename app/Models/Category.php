<?php

namespace App\Models;

use App\Models\Trait\CreatedUpdatedByRelationship;
use App\Models\Trait\ModelBoot;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use CreatedUpdatedByRelationship, SoftDeletes, ModelBoot;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
        'deleted_at' => 'timestamp',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected $with = ['createdBy', 'updatedBy'];

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function getForm()
    {
        return [
            TextInput::make('name')
                ->columnSpanFull()
                ->required()
                ->minLength(3)
                ->maxLength(255),
            RichEditor::make('description')
                ->columnSpanFull(),
            Toggle::make('status')
                ->default(true)
        ];
    }
}
