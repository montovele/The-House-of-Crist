<?php

namespace Database\Factories;

use App\Models\CommentAndCalification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; 

class CommentAndCalificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommentAndCalification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        //Creacion del factory CommentAndCalification
        return [
            'comments' => Str::limit($this->faker->paragraphs($nb = 3, $asText = true,500)),
            'calification' =>  $this->faker->numberBetween(1, 5),
        ];
    }
}
