<?php

namespace Tests\Feature\Courses;

use App\Http\Controllers\Course\CourseController;
use App\Models\Course;
use Tests\Cases\TestCaseFeature;

class CourseTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->useActionsFromController(CourseController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'title', 'description', 'start_date', 'end_date',
            'image_url', 'created_at', 'updated_at'
        ];
    }

    public function test_should_list_courses()
    {
        Course::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_course()
    {
        $course = Course::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $course->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_create_course_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'title' => 'Teste',
            'description' => 'Descrição',
            'start_date' => '2030-01-01',
            'end_date' => '2030-01-03',
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $course = Course::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $course->title);
        $this->assertEquals('Descrição', $course->description);
        $this->assertEquals('2030-01-01 00:00:00', $course->start_date);
        $this->assertEquals('2030-01-03 00:00:00', $course->end_date);
    }

    public function test_should_not_create_course_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_course_when_valid_data()
    {
        $course = Course::factory()
            ->create();

        $this->postJson($this->controllerAction('update', $course->id), [
            'title' => 'Teste',
            'description' => 'Descrição',
            'start_date' => '2030-01-01',
            'end_date' => '2030-01-03',
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $course->refresh();
       $this->assertEquals('Teste', $course->title);
        $this->assertEquals('Descrição', $course->description);
        $this->assertEquals('2030-01-01 00:00:00', $course->start_date);
        $this->assertEquals('2030-01-03 00:00:00', $course->end_date);
    }

    public function test_should_not_update_course_when_invalid_data()
    {
        $course = Course::factory()
            ->create();

        $this->postJson($this->controllerAction('update', $course->id), [])
            ->assertUnprocessable();
    }

    public function test_should_delete_course()
    {
        $course = Course::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $course->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
