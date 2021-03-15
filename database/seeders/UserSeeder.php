<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
            'name' => 'Nicolas',
            'last_name' => 'Rojas Poblete',
            'email' => 'nicrojas16@alumnos.utalca.cl',
            'password' => bcrypt('12345678'),
        ])->assignRole('admin');

        User::create([
            'name' => 'Mauricio',
            'last_name' => 'Gonzalez',
            'email' => 'mgonzalez16@alumnos.utalca.cl',
            'password' => bcrypt('12345678'),
        ])->assignRole('guest');

        User::create([
            'name' => 'Jessica',
            'last_name' => 'Lara',
            'email' => 'jlara16@alumnos.utalca.cl',
            'password' => bcrypt('12345678'),
        ])->assignRole('guest');

        User::create([
            'name' => 'Williams',
            'last_name' => 'Herrera',
            'email' => 'wherrera16@alumnos.utalca.cl',
            'password' => bcrypt('12345678'),
        ])->assignRole('guest');

        User::factory(10)->create();
    }
}
