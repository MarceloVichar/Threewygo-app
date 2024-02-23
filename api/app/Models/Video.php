<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Video extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'title',
        'description',
        'course_id',
    ];

    protected static function newFactory()
    {
        return VideoFactory::new();
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function registerImage(): void
    {
        $this->addMediaCollection('video_images')
            ->singleFile();
    }

    public function getImageAttribute()
    {
        return optional($this->getFirstMedia('video_images'))->getFullUrl();
    }

    public function getVideoAttribute()
    {
        return optional($this->getFirstMedia('video_files'))->getFullUrl();
    }

    public function getVideoSizeAttribute()
    {
        return optional($this->getFirstMedia('video_files'))->size;
    }
}
