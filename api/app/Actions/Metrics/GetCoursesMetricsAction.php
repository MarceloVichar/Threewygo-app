<?php

namespace App\Actions\Metrics;

use App\Models\Course;

class GetCoursesMetricsAction
{
    public function execute()
    {
        $courses = Course::with('videos')->get();

        return $courses->map(function ($course) {
            $totalVideoSize = $course->videos->sum(function ($video) {
               return round($video->getVideoSizeAttribute() / 1024 / 1024, 3);
            });

            return [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'start_date' => output_date_format($course->start_date),
                'end_date' => output_date_format($course->end_date),
                'image_url' => $course->getImageAttribute(),
                'created_at' => output_date_format($course->created_at),
                'updated_at' => output_date_format($course->updated_at),
                'total_video_size' => $totalVideoSize,
                'videos_count' => $course->videos->count(),
            ];
        });
    }
}
