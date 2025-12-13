<?php

namespace Database\Factories\Modules\Company\Domain\Models;

use App\Modules\Company\Domain\Models\CompanyPosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Modules\Company\Domain\Models\Company;
use App\Modules\Company\Domain\Models\PositionTemplate;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyPositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = CompanyPosition::class;

    public function definition(): array
    {
        return [
            'company_id' =>  Company::query()->inRandomOrder()->value('id') ?? Company::factory(),
            'position_template_id' =>  PositionTemplate::query()->inRandomOrder()->value('id') ?? PositionTemplate::factory(),
            'name' => $this->faker->jobTitle(),
            'description' => $this->faker->sentence(),
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'updated_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
