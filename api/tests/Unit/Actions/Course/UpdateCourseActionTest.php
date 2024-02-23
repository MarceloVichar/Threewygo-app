<?php

namespace Tests\Unit\Actions\Course;

use App\Actions\Course\UpdateCourseAction;
use App\Data\Course\CourseData;
use App\Models\Course;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateCourseActionTest extends TestCaseUnit
{
    public function test_should_create_course()
    {
        $data = CourseData::from([
           'title' => 'test',
            'description' => 'description',
            'start_date' => '2025-01-01',
            'end_date' => '2026-01-03',
        ]);

        $model = $this->mock(Course::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->andReturnSelf();
        });

        $result = (new UpdateCourseAction())->execute($model, $data);

        $this->assertInstanceOf(Course::class, $result);
    }
}
