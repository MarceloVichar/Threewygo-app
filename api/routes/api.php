<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('courses', \App\Http\Controllers\Course\CourseController::class)
    ->except('update');

Route::post('courses/{course}', [\App\Http\Controllers\Course\CourseController::class, 'update'])
    ->name('courses.update');

Route::apiResource('videos', \App\Http\Controllers\Video\VideoController::class)
    ->except('update');

Route::post('videos/{video}', [\App\Http\Controllers\Video\VideoController::class, 'update'])
    ->name('videos.update');
