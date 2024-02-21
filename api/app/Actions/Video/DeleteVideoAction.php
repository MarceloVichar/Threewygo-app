<?php

namespace App\Actions\Video;

use App\Models\Video;

class DeleteVideoAction
{
    public function execute(Video $video): Video
    {
        $video->clearMediaCollection('video_images');
        $video->clearMediaCollection('video_files');

        return tap($video)
            ->delete();
    }
}
