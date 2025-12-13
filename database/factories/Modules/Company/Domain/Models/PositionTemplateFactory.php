<?php

namespace Database\Factories\Modules\Company\Domain\Models;

use App\Modules\Company\Domain\Models\PositionTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PositionTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PositionTemplate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->jobTitle(),
            'description' => $this->faker->sentence(),
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'updated_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
