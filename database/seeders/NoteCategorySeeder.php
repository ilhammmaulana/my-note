<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Note;
use App\Models\NoteCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NoteCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryFake = Category::where('category_name', 'belajar')->first();
        collect([
            "admin@gmail.com",
        ])->each(function ($email) use ($categoryFake) {
            $id = User::where('email', $email)->select('id')->first()->id;
            $notes = Note::where('created_by', $id)->select('id')->get();
            foreach ($notes as $index => $note) {
                NoteCategory::create([
                    "note_id" => $note['id'],
                    "category_id" => $categoryFake->id
                ]);
            }
        });
    }
}
