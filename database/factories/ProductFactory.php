<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class; 

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        //Creacion del factory Product
        return [
            'name' =>$this->faker->unique()->sentence(),
            'description'=>Str::limit($this->faker->paragraph(),100), 
            'price' =>  $this->faker->randomFloat(2, 1, 100),
            'disponibility' =>  $this->faker->randomElement(['available', 'unavailable']),
            'qty' =>  $this->faker->randomNumber(4),
            'image' =>  '/image.png',
        ];
    }
}
