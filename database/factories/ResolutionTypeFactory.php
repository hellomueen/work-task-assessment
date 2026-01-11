<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ResolutionType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResolutionType>
 */
class ResolutionTypeFactory extends Factory
{
    protected $model = ResolutionType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
