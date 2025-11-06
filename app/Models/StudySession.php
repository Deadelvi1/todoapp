<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudySession extends Model
{
    use HasFactory;

    protected $table = 'study_sessions';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'study_goal_id',
        'duration_minutes',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function studyGoal()
    {
        return $this->belongsTo(StudyGoal::class, 'study_goal_id', 'id');
    }
}
