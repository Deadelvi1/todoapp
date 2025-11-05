<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Reminder extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'todo_id',
        'remind_at',
        'message',
        'is_sent',
    ];

    protected $casts = [
        'is_sent' => 'boolean',
        'remind_at' => 'datetime',
    ];

    // Relasi
    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
