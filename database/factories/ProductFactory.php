<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'barcode' => $this->faker->word(),
            'category_id' => Category::factory(),
            'sub_category_id' => SubCategory::factory(),
            'sub_sub_category_id' => SubSubCategory::factory(),
            'brand_id' => Brand::factory(),
            'discount' => Discount::factory(),
            'description' => $this->faker->text(),
            'deleted_at' => $this->faker->dateTime(),
            'created_by' => $this->faker->randomNumber(),
            'updated_by' => $this->faker->randomNumber(),
            'discount_id' => Discount::factory(),
        ];
    }
}
