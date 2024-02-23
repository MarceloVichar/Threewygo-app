<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+15 days');
        $endDate = (clone $startDate)->modify('+3 days');

        return [
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
