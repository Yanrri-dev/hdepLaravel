<?php

namespace Database\Factories;

use App\Models\Modulo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ModuloFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Modulo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       
        $name=$this->faker->unique()->sentence($nb_words=3,$variable_nb_words=True);
        return [
            'name' => $name,
            'slug' => Str::slug($name),     
        ];
    }
}
