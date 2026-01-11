<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WorkTask;
use App\Models\Call;
use App\Models\ResolutionType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkTask>
 */
class WorkTaskFactory extends Factory
{
    protected $model = WorkTask::class;

    public function definition(): array
    {
        return [
            'call_id' => Call::factory(),
            'resolution_type_id' => ResolutionType::factory(),
            'work_started_at' => null,
            'work_completed_at' => null,
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'updated_at' => now(),
        ];
    }

    public function withCreatedAt($dateTime)
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => $dateTime,
        ]);
    }
}

