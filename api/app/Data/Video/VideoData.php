<?php

namespace App\Data\Video;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class VideoData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $title,

        #[Required, StringType]
        public string $description,

        #[File]
        public        $image,

        #[File]
        public        $video,

        #[Required, IntegerType, Exists('courses', 'id')]
        public int    $course_id
    )
    {
    }
}
