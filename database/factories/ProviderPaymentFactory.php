<?php

namespace Database\Factories;

use App\Models\ProviderPayment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProviderPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProviderPayment::class; 

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        //Creacion del factory ProviderPayment
        return [
            'payment_amount' =>  $this->faker->randomNumber(4),
        ];
    }
}
