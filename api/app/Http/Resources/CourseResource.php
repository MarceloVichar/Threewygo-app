<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => output_date_format($this->start_date),
            'end_date' => output_date_format($this->end_date),
            'image_url' => $this->getImageAttribute(),
            'videos' => VideoResource::collection($this->whenLoaded('videos')),
            'created_at' => output_date_format($this->created_at),
            'updated_at' => output_date_format($this->updated_at),
        ];
    }
}
