<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['topic_id', 'title', 'content', 'order', 'xp_reward', 'video_url'];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function slides(): HasMany
    {
        return $this->hasMany(LessonSlide::class)->orderBy('order');
    }

    public function quiz(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Quiz::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(UserLessonProgress::class);
    }
}
