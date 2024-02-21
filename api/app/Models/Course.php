<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function registerImage(): void
    {
        $this->addMediaCollection('course_images')
            ->singleFile();
    }

    public function getImageAttribute()
    {
        return optional($this->getFirstMedia('course_images'))->getFullUrl();
    }
}
