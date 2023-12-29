<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Books;
use App\Models\BookLoans;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookLoans>
 */
class BookLoansFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    protected $model = BookLoans::class;

    public function definition(): array
    {
        return [
            'book_id' => fake()->randomElement(Books::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'can_date' => now(),
            'due_date' => now()->addDays(7),
            //null or random date
            'return_date' => fake()->randomElement([null, now()->addDays(7), now()->addDays(14), now()->addDays(21), now()->addDays(28)]),
            'extended' => randomElement(['yes', 'no']),
            'extension_tale_cate' => $this->faker->sentence,
            'penalty_amount' => fake()->randomElement([null,'100', '200', '300', '400', '500']),
            'penalty_status' => fake()->randomElement(['paid', 'unpaid']),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'added_by' => fake()->randomElement(User::pluck('id')->toArray()),
            'updated_by' => fake()->randomElement(User::pluck('id')->toArray()),
        ];
    }
}
