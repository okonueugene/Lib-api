<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([

            UserSeeder::class,
            // BookSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            // BookLoanSeeder::class,
            BookShelfSeeder::class,

        ]);
        \App\Models\User::factory(20)->create();

        \App\Models\BookLoans::factory(200)->create();
    }
}
