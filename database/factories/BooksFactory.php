<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Books>
 */
class BooksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Books::class;
    public function definition(): array
    {
        $categoryID = $this->faker->randomElement(\App\Models\Category::pluck('id')->toArray());
        $subCategoryIDs = \App\Models\SubCategory::where('category_id', $categoryID)->pluck('id')->toArray();
        return [
            'name' => $this->faker->name(),
            'publisher' => $this->faker->name(),
            'category_id' => $categoryID,
            'sub_category_id' => $this->faker->randomElement($subCategoryIDs),
            'description' => $this->faker->text(),
            'pages' => $this->faker->numberBetween(1, 100),
            'image' => $this->faker->imageUrl(),
            'added_by' => fake()->randomElement(\App\Models\User::pluck('id')->toArray()),
        ];
    }
}