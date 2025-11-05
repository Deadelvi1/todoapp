<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudySession extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'study_goal_id',
        'duration_minutes',
        'note',
    ];

    // Relasi
    public function studyGoal()
    {
        return $this->belongsTo(StudyGoal::class);
    }
}
