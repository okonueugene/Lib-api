<?php

namespace Database\Seeders;

use Goutte\Client;
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
        $descriptions = json_decode(file_get_contents('https://raw.githubusercontent.com/okonueugene/Lib-api/main/public/books.json'), true);


        $index = 0;
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
                    'description' => $this->getDescription($descriptions, $index),
                    'pages' => 100,
                    'image' => $book[0],
                    'added_by' => 1,
                ]);

                //Create the book copies
                \App\Models\BookCopy::create([
                    'book_id' => $book->id,
                    'copy_number' => random_int(10, 200),
                    'is_available' => true,
                ]);

                $index++;

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
                    'description' => $this->getDescription($descriptions, $index),
                    'pages' => 100,
                    'image' => $book[0],
                    'added_by' => 1,
                ]);

                //Create the book copies
                \App\Models\BookCopy::create([
                    'book_id' => $book->id,
                    'copy_number' => random_int(10, 200),
                    'is_available' => true,
                ]);

                $index++;
            }
        }
    }

    private function getDescription($descriptions, $index)
    {
        // If the descriptions is an array and the index is within bounds
        if (is_array($descriptions) && isset($descriptions[$index])) {
            return $descriptions[$index];
        }

        // If the descriptions is not an array or the index is out of bounds, return a default description
        return 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.';
    }


}
