<?php

namespace Database\Factories;

use App\Models\Action;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Action::class; 

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        //Creacion del factory Action
        return [
            'user_id' =>  User::factory(),
            'action' => $this->faker->randomElement(['create', 'delete','update','login']),
        ];
    }
}
