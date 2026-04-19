<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LessonSlide extends Model
{
    use HasFactory;

    protected $fillable = ['lesson_id', 'title', 'content', 'type', 'order', 'visualization_data'];

    protected $casts = [
        'content' => 'array',
        'visualization_data' => 'array',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
