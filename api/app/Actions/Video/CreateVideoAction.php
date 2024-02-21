<?php

namespace App\Actions\Video;

use App\Data\Video\VideoData;
use App\Models\Video;

class CreateVideoAction
{
    public function execute(VideoData $data): Video
    {
        $dataArray = $data->toArray();
        $course = app(Video::class)
            ->create($dataArray);

        if ((bool)$data->image) {
            $course->addMedia($data->image)
                ->usingFileName("video-image-$course->id.png")
                ->toMediaCollection('video_images');
        }

        if ((bool)$data->video) {
            $course->addMedia($data->video)
                ->usingFileName("video-$course->id.mp4")
                ->toMediaCollection('video_files');
        }

        return $course;
    }
}
