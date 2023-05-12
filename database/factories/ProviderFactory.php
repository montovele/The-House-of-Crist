<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\Service;
use App\Models\Product;
use App\Models\ProviderPayment;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class; 

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        //Creacion del factory Provider
        return [
            'provider_name' =>  $this->faker->company(),
            'services_id'=>Service::factory(),
            'products_id'=>Product::factory(),
            'providers_payment_id'=>ProviderPayment::factory(),
            'reservations_id'=>Reservation::factory(),
            'phone_number' =>  $this->faker->phoneNumber(), 
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'address' =>  $this->faker->address(),
            'rfc' =>  'AAPA901115MU8',
            'bank_acount' =>  $this->faker->unique()->bankAccountNumber(),
        ];
    }
}
