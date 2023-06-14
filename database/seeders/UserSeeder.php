<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => 'Ilham Maulana',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('larapel02'), // password
            'phone' => "08954638229",
            'role_id' => 1,
            'photo' => null
        ]);
        User::create([
            "name" => 'Nabila',
            'email' => 'nabila@gmail.com',
            'password' => bcrypt('larapel02'), // password
            'phone' => "08111",
            'role_id' => 1,
            'photo' => null
        ]);
        User::create([
            "name" => 'Johan',
            'email' => 'johan@gmail.com',
            'password' => bcrypt('larapel02'), // password
            'phone' => "081112",
            'role_id' => 1,
            'photo' => null
        ]);
        User::factory(10)->create();
    }
}
