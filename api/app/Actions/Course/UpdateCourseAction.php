<?php

namespace App\Actions\Course;

use App\Data\Course\CourseData;
use App\Models\Course;
use Carbon\Carbon;

class UpdateCourseAction
{
    public function execute(Course $course, CourseData $data): Course
    {
        if ($data->start_date) {
            $data->start_date = Carbon::parse( $data->start_date)->toDateTimeString();
        }
        if ($data->end_date) {
            $data->end_date = Carbon::parse( $data->end_date)->toDateTimeString();
        }

        tap($course)
            ->update($data->toArray());

        if ((bool)$data->image) {
            $course->clearMediaCollection('course_images');

            $course->addMedia($data->image)
                ->usingFileName("course-$course->id.png")
                ->toMediaCollection('course_images');
        }

        return $course;
    }
}
