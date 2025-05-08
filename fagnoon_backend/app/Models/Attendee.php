<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'eventable_id',
        'eventable_type',
        'name',
        'phone',
        'adult_count',
        'kid_count',
        'check_in_time',
    ];

    /**
     * Get the parent eventable model (reservation or birthday).
     */
    public function eventable(): MorphTo
    {
        return $this->morphTo();
    }
}

