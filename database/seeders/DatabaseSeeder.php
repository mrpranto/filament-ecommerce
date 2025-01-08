<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Discount;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Unit;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Pranto',
            'email' => 'pranto@gmail.com',
            'password' => bcrypt('11223344'),
        ]);

        Category::factory()->count(1000)->create();

        SubCategory::factory()->count(1000)->create();

        SubSubCategory::factory()->count(1000)->create();

        Discount::factory()->count(1000)->create();

        Brand::factory()->count(1000)->create();

        Unit::factory()->count(1000)->create();

    }
}
