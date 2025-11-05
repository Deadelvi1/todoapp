<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudyGoal extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'title',
        'target_hours',
        'achieved_hours',
        'status',
        'score',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studySessions()
    {
        return $this->hasMany(StudySession::class);
    }
}
