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
        $superAdmin = User::create([
            "name" => 'Ilham Maulana',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('larapel02'), // password
            'phone' => "08954638229",
            'photo' => null
        ])->assignRole('super_admin');
        User::create([
            "name" => 'Nabila',
            'email' => 'nabila@gmail.com',
            'password' => bcrypt('larapel02'), // password
            'phone' => "08111",
            'photo' => null
        ])->assignRole('admin');
        User::create([
            "name" => 'Johan',
            'email' => 'johan@gmail.com',
            'password' => bcrypt('larapel02'), // password
            'phone' => "081112",
            'photo' => null
        ])->assignRole('admin');
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
