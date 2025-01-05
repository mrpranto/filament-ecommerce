<?php

namespace App\Models\Trait;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait CreatedUpdatedByRelationship
{
    /**
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
