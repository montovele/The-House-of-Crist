<?php

namespace Database\Factories;

use App\Models\Bill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Provider\DateTime;

class BillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bill::class; 

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        //Creacion del factory Bill
        return [
            'issuance_date' =>$this->faker->dateTimeThisCentury()->format('Y-m-d H:i:s'),
            'expiration_date'=>$this->faker->dateTimeThisCentury()->format('Y-m-d H:i:s'),
            'total_amount' =>  $this->faker->randomNumber(3),
        ];
    }
}
