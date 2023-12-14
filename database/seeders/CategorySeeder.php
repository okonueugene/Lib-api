<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Fiction',
            'Non-Fiction',
        ];

        $description = [
            'Fiction' => 'Fiction is the telling of stories which are not real. More specifically, fiction is an imaginative form of narrative, one of the four basic rhetorical modes. Although the word fiction is derived from the Latin fingo, fingere, finxi, fictum, "to form, create", works of fiction need not be entirely imaginary and may include real people, places, and events. Fiction may be either written or oral. Although not all fiction is necessarily artistic, fiction is largely perceived as a form of art or entertainment. The ability to create fiction and other artistic works is considered to be a fundamental aspect of human culture, one of the defining characteristics of humanity.',
            'Non-Fiction' => 'Nonfiction or non-fiction is any document, or content that purports in good faith to represent truth and accuracy regarding information, events, or people. Nonfiction content may be presented either objectively or subjectively, and may sometimes take the form of a story. Nonfiction is one of the fundamental divisions of narrative (specifically, prose) writing— in contrast to fiction, which offers information, events, or characters expected to be partly or largely imaginary, or else leaves open if and how the work refers to reality.',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'description' => $description[$category],
            ]);
        }
    }
}