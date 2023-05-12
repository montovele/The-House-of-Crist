<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class; 

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        //Creacion del factory Activity
        return [
            'service_name' =>$this->faker->word(),
            'description' =>  $this->faker->sentence(),
            'price' =>  $this->faker->randomFloat(2, 1, 100),
            'disponibility' =>  $this->faker->randomElement(['available', 'unavailable']),
            'duration' =>  $this->faker->randomElement([30, 60, 90, 120]),
            'image' => '/image.png',
        ];
    }
}
