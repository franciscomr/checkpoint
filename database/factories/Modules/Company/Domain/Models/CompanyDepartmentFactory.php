<?php

namespace Database\Factories\Modules\Company\Domain\Models;

use App\Modules\Company\Domain\Models\CompanyDepartment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Modules\Company\Domain\Models\Company;
use App\Modules\Company\Domain\Models\DepartmentTemplate;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyDepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = CompanyDepartment::class;

    public function definition(): array
    {
        return [
            'company_id' =>  Company::query()->inRandomOrder()->value('id') ?? Company::factory(),
            'department_template_id' =>  DepartmentTemplate::query()->inRandomOrder()->value('id') ?? DepartmentTemplate::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'updated_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
