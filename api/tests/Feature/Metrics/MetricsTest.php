<?php

namespace Tests\Feature\Metrics;

use App\Http\Controllers\Metrics\MetricsController;
use App\Models\Course;
use App\Models\Video;
use Tests\Cases\TestCaseFeature;

class MetricsTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->useActionsFromController(MetricsController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'title', 'description', 'start_date', 'end_date',
            'image_url', 'videos_count', 'total_video_size'
        ];
    }

    public function test_should_list_courses_metrics()
    {
        Course::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('metrics'))
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonStructure([
                '*' => $this->getFormatResourceStructure(),
            ]);
    }

    public function test_should_list_courses_metrics_with_videos()
    {
        $course = Course::factory()
            ->create();

        Course::factory()
            ->count(2)
            ->create();

        Video::factory()
            ->count(2)
            ->create([
                'course_id' => $course->id,
            ]);

        $response = $this->getJson($this->controllerAction('metrics'))
            ->assertOk()
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => $this->getFormatResourceStructure(),
            ]);

        $courses = $response->json();

        $foundCourse = null;
        foreach ($courses as $c) {
            if ($c['id'] == $course->id) {
                $foundCourse = $c;
                break;
            }
        }

        $this->assertNotNull($foundCourse);
        $this->assertEquals(2, $foundCourse['videos_count']);
    }
}
