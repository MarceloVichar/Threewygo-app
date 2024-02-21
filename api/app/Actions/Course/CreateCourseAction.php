<?php

namespace App\Actions\Course;

use App\Data\Course\CourseData;
use App\Models\Course;
use Carbon\Carbon;

class CreateCourseAction
{
    public function execute(CourseData $data): Course
    {
        if ($data->start_date) {
            $data->start_date = Carbon::parse( $data->start_date)->toDateTimeString();
        }
        if ($data->end_date) {
            $data->end_date = Carbon::parse( $data->end_date)->toDateTimeString();
        }

        $dataArray = $data->toArray();
        $course = app(Course::class)
            ->create($dataArray);

        if ((bool)$data->image) {
            $course->addMedia($data->image)
                ->usingFileName("course-$course->id.png")
                ->toMediaCollection('course_images');
        }

        return $course;
    }
}
