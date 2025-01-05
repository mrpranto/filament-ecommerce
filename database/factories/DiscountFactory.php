<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Discount;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'type' => $this->faker->randomElement(["flat","percentage"]),
            'deleted_at' => $this->faker->dateTime(),
            'created_by' => $this->faker->randomNumber(),
            'updated_by' => $this->faker->randomNumber(),
        ];
    }
}
