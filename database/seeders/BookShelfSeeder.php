<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $url = 'https://raw.githubusercontent.com/okonueugene/Lib-api/main/library.json';
        $data = json_decode(file_get_contents($url), true);

        foreach ($data as $book) {
            //Find the subcategory
            $subcategory = SubCategory::where('name', 'like', '%' . $book[3] . '%')->first();
            //If its truthy, return the category id  and the subcategory id
            if($subcategory) {
                $subcategory_id = $subcategory->id;
                $category_id = $subcategory->category_id;

                //Create the book
                $book = \App\Models\Books::create([
                    'name' => $book[1],
                    'publisher' => $book[2],
                    'category_id' => $category_id,
                    'sub_category_id' => $subcategory_id,
                    'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
                    'pages' => 100,
                    'image' => $book[0],
                    'added_by' => 1,
                ]);
            } else {
                //Check if the category is fiction or non-fiction
                $fictional = SubCategory::where('category_id', 1)->pluck('name')->toArray();
                $non_fictional = SubCategory::where('category_id', 2)->pluck('name')->toArray();



                //Create the subcategory and issue category id as 1 or 2
                $subcategory = \App\Models\SubCategory::firstOrCreate([
                    'name' => $book[3],
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                    'category_id' => in_array($book[3], $fictional) ? 1 : 2,
                ]);

                //Create the book
                $book = \App\Models\Books::create([
                    'name' => $book[1],
                    'publisher' => $book[2],
                    'category_id' => 2,
                    'sub_category_id' => $subcategory->id,
                    'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
                    'pages' => 100,
                    'image' => $book[0],
                    'added_by' => 1,
                ]);
            }
        }
    }
}