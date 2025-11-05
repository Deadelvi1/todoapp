<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;
    protected $fillable = [
        'name',
        'email',
        'password', ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi
    public function studyGoals()
    {
        return $this->hasMany(StudyGoal::class);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}
