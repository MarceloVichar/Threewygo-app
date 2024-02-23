<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $course = Course::factory()->create([
            'title' => 'Curso de realidade virtual',
            'description' => 'Entenda as vantagens e desvantagens dos óculos de realidade virtual.',
        ]);

        $video = Video::factory()->create([
            'course_id' => $course->id,
            'title' => 'Video 1',
            'description' => 'Video de realidade virtual 1'
        ]);

        $video->copyMedia(database_path('seeders/files/imagem_exemplo.png'))->toMediaCollection('video_images');
        $video->copyMedia(database_path('seeders/files/video_exemplo.mp4'))->toMediaCollection('video_files');
    }
}
