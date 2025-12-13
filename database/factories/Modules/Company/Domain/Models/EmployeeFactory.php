<?php

namespace Database\Factories\Modules\Company\Domain\Models;

use App\Modules\Company\Domain\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Modules\Company\Domain\Models\Branch;
use App\Modules\Company\Domain\Models\CompanyPosition;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'branch_id' =>  Branch::query()->inRandomOrder()->value('id') ?? Branch::factory(),
            'company_position_id' =>  CompanyPosition::query()->inRandomOrder()->value('id') ?? CompanyPosition::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'employee_code' => $this->faker->unique()->bothify('E-#####'),
            'email' => $this->faker->unique()->email(),
            'photo_path' => $this->faker->imageUrl(200, 200, 'business'),
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'updated_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
