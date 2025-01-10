<?php

namespace App\Models;

use App\Models\Trait\CreatedUpdatedByRelationship;
use App\Models\Trait\ModelBoot;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use ModelBoot, SoftDeletes, HasFactory, CreatedUpdatedByRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'amount',
        'type',
        'status',
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
        'amount' => 'float',
        'deleted_at' => 'timestamp',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public static function getForm()
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Section::make()
                ->schema([
                    TextInput::make('amount')
                        ->required()
                        ->numeric()
                        ->suffix(fn($get) => $get('amount_suffix') ?? 'BDT'),

                    Select::make('type')
                        ->live()
                        ->required()
                        ->options([
                            'percentage' => 'Percentage (%)',
                            'flat' => 'Flat (BDT)',
                        ])
                        ->native(false)
                        ->afterStateUpdated(function ($set, $state) {
                            if ($state === 'flat') {
                                $set('amount_suffix', 'BDT');
                            } else {
                                $set('amount_suffix', '%');
                            }
                        }),
                ])
                ->columns(2),

            Toggle::make('status')
                ->default(true)
        ];
    }
}
