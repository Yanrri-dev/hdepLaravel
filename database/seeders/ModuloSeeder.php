<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulos = Modulo::factory(25)->create();

        foreach ($modulos as $modulo){
            Image::factory(1)->create([
                'imageable_id' => $modulo->id,
                'imageable_type' => Modulo::class,
            ]);
        }
    }
}
