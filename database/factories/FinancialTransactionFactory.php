<?php

namespace Database\Factories;

use App\Models\FinancialTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FinancialTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinancialTransaction::class; 

    /**
     * Define the model's default state.
     * 
     * @return array
     */

    public function definition()
    {
        //Creacion del factory FinancialTransaction
        return [
            'user_id' =>  User::factory(),
            'action' =>$this->faker->randomElement(['payment_to_provider', 'reservation_payment']),
            'reference_transaction' =>'transaction',
            'amount_transaction' =>$this->faker->randomNumber(4),
        ];
    }
}
