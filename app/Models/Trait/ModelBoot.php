<?php

namespace App\Models\Trait;

use App\Models\User;

trait ModelBoot
{
    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->fill([
                'created_by' => auth()->id() ?? optional(User::query()->first())->id,
                'updated_by' => auth()->id() ?? optional(User::query()->first())->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        static::updating(function ($model) {
            $model->fill([
                'updated_at' => now(),
                'updated_by' => auth()->id() ?? optional(User::query()->first())->id,
            ]);
        });
    }
}
