<?php

namespace App\Actions\Video;

use App\Data\Video\VideoData;
use App\Models\Video;

class UpdateVideoAction
{
    public function execute(Video $video, VideoData $data): Video
    {
        tap($video)
            ->update($data->toArray());

        if ((bool)$data->image) {
            $video->clearMediaCollection('video_images');

            $video->addMedia($data->image)
                ->usingFileName("course-$video->id.png")
                ->toMediaCollection('video_images');
        }

        return $video;
    }
}
