<?php

namespace App\Actions\Course;

use App\Actions\Video\DeleteVideoAction;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class DeleteCourseAction
{
    public function execute(Course $course)
    {
        try {
            DB::beginTransaction();

            $course->clearMediaCollection('course_images');

            foreach ($course->videos as $video) {
                app(DeleteVideoAction::class)
                    ->execute($video);
            }

            tap($course)
                ->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
        }
    }
}
