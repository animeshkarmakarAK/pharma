<?php

namespace Module\GovtStakeholder\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\GovtStakeholder\App\Models\Organization;
use Module\GovtStakeholder\App\Models\organizationUnitStatistic;

class OrganizationUnitStatisticFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrganizationUnitStatistic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $organizationIDs = Organization::pluck('id');
        return [
            'organization_id' => $this->faker->randomElement($organizationIDs),
            'total_new_recruits' => $this->faker->randomNumber(),
            'total_vacancy' => $this->faker->randomNumber(),
            'total_occupied_position' => $this->faker->randomNumber(),
            'survey_date' => $this->faker->dateTimeBetween('-5 months', 'now'),
        ];
    }
}
