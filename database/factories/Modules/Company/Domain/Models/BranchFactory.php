<?php

namespace Database\Factories\Modules\Company\Domain\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Modules\Company\Domain\Models\Company;
use App\Modules\Company\Domain\Models\Branch;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Branch::class;

    public function definition(): array
    {
        return [
            'company_id' =>  Company::query()->inRandomOrder()->value('id') ?? Company::factory(),
            'name' => $this->faker->unique()->word() . ' - ' . Str::random(5),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'updated_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
