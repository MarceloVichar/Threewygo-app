<?php

namespace App\Http\Controllers\Metrics;

use App\Actions\Metrics\GetCoursesMetricsAction;
use App\Http\Controllers\Controller;

class MetricsController extends Controller
{
    public function metrics()
    {
        $result = app(GetCoursesMetricsAction::class)
            ->execute();
        return response()->json($result, 200);
    }
}
