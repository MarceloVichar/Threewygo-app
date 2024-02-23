<?php

namespace Tests\Feature\Videos;

use App\Http\Controllers\Video\VideoController;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Cases\TestCaseFeature;

class VideoTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->useActionsFromController(VideoController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'title', 'description', 'video_url',
            'image_url', 'created_at', 'updated_at'
        ];
    }

    public function test_should_list_videos()
    {
        Video::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_video()
    {
        $video = Video::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $video->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_create_video_when_valid_data()
    {
        $course = Course::factory()
            ->create();

        $videoFile = UploadedFile::fake()->create('video.mp4', 1000);

        $response = $this->postJson($this->controllerAction('store'), [
            'title' => 'Teste',
            'description' => 'Descrição',
            'course_id' => $course->id,
            'video' => $videoFile,
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $video = Video::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $video->title);
        $this->assertEquals('Descrição', $video->description);
        $this->assertEquals($course->id, $video->course_id);

        $videoUrl = $video->getVideoAttribute();
        $videoPath = parse_url($videoUrl, PHP_URL_PATH);
        $videoPath = ltrim($videoPath, '/storage');
        Storage::disk('public')->assertExists($videoPath);
    }

    public function test_should_not_create_video_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_video_when_valid_data()
    {
        $video = Video::factory()
            ->create();

        $this->postJson($this->controllerAction('update', $video->id), [
            'title' => 'Teste',
            'description' => 'Descrição',
            '_METHOD' => 'PUT',
            'course_id' => $video->course_id,
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $video->refresh();
        $this->assertEquals('Teste', $video->title);
        $this->assertEquals('Descrição', $video->description);
    }

    public function test_should_not_update_video_when_invalid_data()
    {
        $video = Video::factory()
            ->create();

        $this->postJson($this->controllerAction('update', $video->id), [])
            ->assertUnprocessable();
    }

    public function test_should_delete_video()
    {
        $course = Course::factory()
            ->create();

        $videoFile = UploadedFile::fake()->create('video.mp4', 1000);

        $response = $this->postJson($this->controllerAction('store'), [
            'title' => 'Teste',
            'description' => 'Descrição',
            'course_id' => $course->id,
            'video' => $videoFile,
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $video = Video::find($response->offsetGet('id'));

        $videoUrl = $video->getVideoAttribute();
        $videoPath = parse_url($videoUrl, PHP_URL_PATH);
        $videoPath = ltrim($videoPath, '/storage');
        Storage::disk('public')->assertExists($videoPath);

        $this->deleteJson($this->controllerAction('destroy', $video->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('videos', ['id' => $video->id]);

        Storage::disk('public')->assertMissing($videoPath);
    }
}
