<?php

namespace App\Data\Course;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CourseData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $title,

        #[Required, StringType]
        public string $description,

        #[Required, StringType, Date]
        public string $start_date,

        #[Required, StringType, Date]
        public string $end_date,

        #[File]
        public $image
    ) {
    }
}
