<?php

namespace Module\CourseManagement\Database\Factories;

use Module\CourseManagement\App\Models\Programme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgrammeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Programme::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title_en' => $this->faker->colorName,
            'title_bn' => $this->faker->colorName,
            'description' => $this->faker->sentence,
            'logo' => $this->faker->image(),
            'code' => $this->faker->unique()->postcode,
            'institute_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'row_status' => 1,
            'created_by' => null,
        ];
    }
}
