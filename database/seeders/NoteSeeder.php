<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categoryFake = Category::where('category_name', 'belajar')->first();
        // Collection for admin
        collect([
            "admin@gmail.com",
        ])->each(function ($email) use ($faker, $categoryFake) {
            $id = User::where('email', $email)->select('id')->first()->id;
            for ($i = 0; $i < 4; $i++) {
                Note::create([
                    "created_by" => $id,
                    "title" => $faker->sentence(2),
                    "body" =>  $faker->paragraph(20),
                    "category_id" => rand(0, 1) === 1 ? null : $categoryFake->id,
                    "favorite" => rand(0, 1) === 1 ? true : false
                ]);
            }
        });
    }
}
