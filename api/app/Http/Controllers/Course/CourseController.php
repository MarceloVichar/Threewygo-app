<?php

namespace App\Http\Controllers\Course;

use App\Actions\Course\CreateCourseAction;
use App\Actions\Course\DeleteCourseAction;
use App\Actions\Course\UpdateCourseAction;
use App\Data\Course\CourseData;
use App\Filters\Shared\EndDateFilter;
use App\Filters\Shared\StartDateFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Spatie\QueryBuilder\AllowedFilter;

class CourseController extends Controller
{
    public function index()
    {
        return pagination(Course::class)
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::custom('start_date_start', new StartDateFilter('start_date')),
                AllowedFilter::custom('start_date_end', new EndDateFilter('start_date')),
                AllowedFilter::custom('end_date_start', new StartDateFilter('end_date')),
                AllowedFilter::custom('end_date_end', new EndDateFilter('end_date')),
            ])
            ->allowedSorts(['title', 'created_at', 'start_date', 'end_date'])
            ->defaultSort('created_at')
            ->resource(CourseResource::class);
    }

    public function show(Course $course)
    {
        $course->loadMissing(['videos']);

        return response()->json(CourseResource::make($course), 200);
    }

    public function store(CourseRequest $request)
    {
        $data = CourseData::validateAndCreate($request->validated());

        $course = app(CreateCourseAction::class)
            ->execute($data);

        return response()->json(CourseResource::make($course), 201);
    }

    public function update(CourseRequest $request, Course $course)
    {
        $data = CourseData::validateAndCreate($request->validated());

        $course = app(UpdateCourseAction::class)
            ->execute($course, $data);

        return response()->json(CourseResource::make($course), 200);
    }

    public function destroy(Course $course)
    {
        app(DeleteCourseAction::class)
            ->execute($course);

        return response()->noContent();
    }
}
