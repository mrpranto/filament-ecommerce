<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class SubSubCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubSubCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sub_category_id' => SubCategory::factory(),
            'name' => $this->faker->name(),
            'deleted_at' => $this->faker->dateTime(),
            'description' => $this->faker->text(),
            'created_by' => $this->faker->randomNumber(),
            'updated_by' => $this->faker->randomNumber(),
        ];
    }
}
