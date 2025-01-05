<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductVariation;

class ProductVariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'size' => $this->faker->word(),
            'color' => $this->faker->word(),
            'material' => $this->faker->word(),
            'badge' => $this->faker->word(),
            'product_id' => Product::factory(),
        ];
    }
}
