<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'type', 'duration_minutes', 'intensity_score', 'distance_km',
        'exercise_name', 'workout_sets', 'workout_reps', 'weight_kg',
        'gym_data', // TAMBAHAN KOLOM JSON
        'notes',
    ];

    // CASTING JSON KE ARRAY
    protected $casts = [
        'gym_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}