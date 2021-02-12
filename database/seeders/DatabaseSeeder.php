<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Modulo;
use App\Models\Image;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Storage::makeDirectory(public_path() . '/storage/modulos');
        Storage::disk('public')->makeDirectory('modulos');
        $this->call(UserSeeder::class);
        Category::factory(4)->create();
        $this->call(ModuloSeeder::class);

    }
}
