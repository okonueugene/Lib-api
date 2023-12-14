<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fictionSubCategories =
        [
            'Fiction' => [
            'Action and Adventure',
            'Historical Fiction',
            'Horror',
            'Detective & Mystery',
            'Romance',
            'Satire',
            'Science Fiction',
            'Thriller',
            'Dystopian',
            'Children’s Fiction']
        ];


        $fictionSubCategoriesDescription =
        [
            'Action and Adventure' => 'Action and Adventure books are full of excitement and suspense. They are filled with physical and mental feats that the main characters must overcome. They are usually set in exotic locations and feature dangerous situations that the protagonist must navigate to get out of trouble.',
            'Historical Fiction' => 'Historical fiction books are set in a time period in the past. They are based on real-world events and attempt to recreate the social and political realities of the time. They often feature famous historical figures as the main characters.',
            'Horror' => 'Horror books are designed to scare the reader. They are filled with frightening situations and terrifying events. They often feature supernatural elements such as ghosts, vampires, and zombies.',
            'Detective & Mystery' => 'Detective and mystery books are filled with enigmas and secrets that the main characters must solve. They are often filled with suspense and intrigue and keep the reader guessing until the end.',
            'Romance' => 'Romance books are all about love and relationships. They are filled with romantic moments and passionate encounters. They often feature a love triangle where the main character must choose between two potential love interests.',
            'Satire' => 'Satire books are designed to make fun of something. They are filled with humor and irony and often feature a sarcastic tone. They are often used to criticize society and politics.',
            'Science Fiction' => 'Science fiction books are set in the future or in outer space. They are filled with futuristic technology and often feature aliens and other life forms. They often explore the consequences of scientific and technological advances.',
            'Thriller' => 'Thriller books are filled with suspense and excitement. They are often fast-paced and feature a lot of action. They often feature a protagonist who is trying to stop a villain from committing a crime.',
            'Dystopian' => 'Dystopian books are set in a future where society has become corrupt and oppressive. They often feature a protagonist who is trying to fight against the system. They often explore themes such as government control, surveillance, and censorship.',
            'Children’s Fiction' => 'Children’s fiction books are designed for young readers. They are often filled with colorful illustrations and feature simple language. They often feature a moral lesson or teach a life lesson.',

        ];

        foreach ($fictionSubCategories as $categoryName => $subcategories) {
            $category = Category::where('name', 'Fiction')->first();
            foreach ($subcategories as $subcategory) {
                SubCategory::create([
                     'name' => $subcategory,
                     'category_id' => $category->id,
                     'description' => $fictionSubCategoriesDescription[$subcategory],
                 ]);
            }
        }

        $nonFictionSubCategories =
        [
           'Non-Fiction' => ['Biographies & Autobiographies',
            'Memoirs',
            'History',
            'Self-Help',
            'Health & Fitness',
            'Travel',
            'Guide',
            'Art',
            'Photography',
            'Cookbooks',
            'Food & Wine',
            'Religion, Spirituality & New Age',
            'Science',
            'Math',
            'Anthology',
            'Poetry',
            'Encyclopedias',
            'Dictionaries',
            'Motivational & Inspirational',
            'True Crime',
            'Crafts, Hobbies & Home',
            'Family & Relationships',
            'Humor',
            'Children’s Non-Fiction',
            'Business & Economics',
            'Politics & Social Sciences',
            'Philosophy',
            'Sports',
            'Law & Criminology',
            'Computers & Technology',
            'Engineering & Transportation',
            'Education & Teaching']
        ];

        $nonFictionSubCategoriesDescription =
        [
            'Biographies & Autobiographies' => 'Biographies and autobiographies are books that tell the story of someone’s life. They are often written by the person themselves or by someone close to them. They are often filled with personal details and anecdotes.',
            'Memoirs' => 'Memoirs are books that tell the story of a specific time period in someone’s life. They are often written by the person themselves or by someone close to them. They are often filled with personal details and anecdotes.',
            'History' => 'History books are filled with facts and information about the past. They are often written by historians and scholars. They are often filled with dates, names, and places.',
            'Self-Help' => 'Self-help books are designed to help people improve their lives. They are often filled with advice and tips on how to be happier, healthier, and more successful. They often feature exercises and activities that the reader can do to improve their life.',
            'Health & Fitness' => 'Health and fitness books are designed to help people improve their health and fitness. They are often filled with advice and tips on how to be healthier and fitter. They often feature exercises and activities that the reader can do to improve their health and fitness.',
            'Travel' => 'Travel books are filled with information about a specific place. They are often written by people who have visited the place and want to share their experiences with others. They are often filled with photos and maps.',
            'Guide' => 'Guide books are filled with information about a specific place. They are often written by people who have visited the place and want to share their experiences with others. They are often filled with photos and maps.',
            'Art' => 'Art books are filled with information about a specific artist or art movement. They are often written by art historians and scholars. They are often filled with photos and illustrations.',
            'Photography' => 'Photography books are filled with information about a specific photographer or photography style. They are often written by photography historians and scholars. They are often filled with photos and illustrations.',
            'Cookbooks' => 'Cookbooks are filled with recipes and cooking tips. They are often written by chefs and food writers. They are often filled with photos and illustrations.',
            'Food & Wine' => 'Food and wine books are filled with recipes and cooking tips. They are often written by chefs and food writers. They are often filled with photos and illustrations.',
            'Religion, Spirituality & New Age' => 'Religion, spirituality, and new age books are filled with information about a specific religion or spiritual practice. They are often written by religious leaders and scholars. They are often filled with photos and illustrations.',
            'Science' => 'Science books are filled with information about a specific scientific topic. They are often written by scientists and scholars. They are often filled with photos and illustrations.',
            'Math' => 'Math books are filled with information about a specific mathematical topic. They are often written by mathematicians and scholars. They are often filled with photos and illustrations.',
            'Anthology' => 'Anthology books are filled with a collection of short stories or poems. They are often written by different authors. They are often filled with photos and illustrations.',
            'Poetry' => 'Poetry books are filled with poems. They are often written by poets. They are often filled with photos and illustrations.',
            'Encyclopedias' => 'Encyclopedias are filled with information about a specific topic. They are often written by experts in the field. They are often filled with photos and illustrations.',
            'Dictionaries' => 'Dictionaries are filled with definitions of words. They are often written by experts in the field. They are often filled with photos and illustrations.',
            'Motivational & Inspirational' => 'Motivational and inspirational books are filled with advice and tips on how to be happier, healthier, and more successful. They are often written by motivational speakers and life coaches. They are often filled with photos and illustrations.',
            'True Crime' => 'True crime books are filled with information about a specific crime. They are often written by journalists and investigators. They are often filled with photos and illustrations.',
            'Crafts, Hobbies & Home' => 'Crafts, hobbies, and home books are filled with information about a specific craft, hobby, or home improvement project. They are often written by experts in the field. They are often filled with photos and illustrations.',
            'Family & Relationships' => 'Family and relationships books are filled with advice and tips on how to have a happy and healthy family life. They are often written by family therapists and counselors. They are often filled with photos and illustrations.',
            'Humor' => 'Humor books are filled with jokes and funny stories. They are often written by comedians and humorists. They are often filled with photos and illustrations.',
            'Children’s Non-Fiction' => 'Children’s non-fiction books are filled with information about a specific topic. They are often written by experts in the field. They are often filled with photos and illustrations.',
            'Business & Economics' => 'Business and economics books are filled with information about a specific business or economic topic. They are often written by business leaders and economists. They are often filled with photos and illustrations.',
            'Politics & Social Sciences' => 'Politics and social sciences books are filled with information about a specific political or social topic. They are often written by political scientists and sociologists. They are often filled with photos and illustrations.',
            'Philosophy' => 'Philosophy books are filled with information about a specific philosophical topic. They are often written by philosophers and scholars. They are often filled with photos and illustrations.',
            'Sports' => 'Sports books are filled with information about a specific sport. They are often written by sports journalists and athletes. They are often filled with photos and illustrations.',
            'Law & Criminology' => 'Law and criminology books are filled with information about a specific legal or criminal topic. They are often written by lawyers and criminologists. They are often filled with photos and illustrations.',
            'Computers & Technology' => 'Computers and technology books are filled with information about a specific computer or technology topic. They are often written by computer scientists and engineers. They are often filled with photos and illustrations.',
            'Engineering & Transportation' => 'Engineering and transportation books are filled with information about a specific engineering or transportation topic. They are often written by engineers and transportation experts. They are often filled with photos and illustrations.',
            'Education & Teaching' => 'Education and teaching books are filled with information about a specific educational or teaching topic. They are often written by educators and teachers. They are often filled with photos and illustrations.',
        ];

        foreach ($nonFictionSubCategories as $categoryName => $subcategories) {
            $category = Category::where('name', 'Non-Fiction')->first();
            foreach ($subcategories as $subcategory) {
                SubCategory::create([
                     'name' => $subcategory,
                     'category_id' => $category->id,
                     'description' => $nonFictionSubCategoriesDescription[$subcategory],
                 ]);
            }
        }
    }
}