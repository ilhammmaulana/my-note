<?php

namespace Database\Seeders;

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
        collect([
            "admin@gmail.com",
        ])->each(function ($email) use ($faker) {
            $id = User::where('email', $email)->select('id')->first()->id;
            for ($i = 0; $i < 2; $i++) {
                Note::create([
                    "created_by" => $id,
                    "title" => $faker->sentence(2),
                    "body" =>  $faker->paragraph(20)
                ]);
            }
        });
    }
}
