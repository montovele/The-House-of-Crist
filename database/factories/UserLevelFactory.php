<?php

namespace Database\Factories;

use App\Models\UserLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserLevel::class; 

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        
        //Creacion del factory UserLevel
        return [
            'levels' =>  $this->faker->randomElement(['admin', 'user','provider']),
        ];
    }
}
 