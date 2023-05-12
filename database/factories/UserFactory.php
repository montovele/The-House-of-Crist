<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\CommentAndCalification;
use App\Models\Bill;
use App\Models\Provider;
use App\Models\UserLevel;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $level = UserLevel::inRandomOrder()->first();
            //Creacion del factory User  
            if($level->levels === 'provider'){
                return [
                    'name' => $this->faker->name(),
                    'payments_id' => Payment::factory(),
                    'comments_id' => CommentAndCalification::factory(),
                    'bills_id' => Bill::factory(),
                    'providers_id' => Provider::factory(),
                    'user_levels_id' => UserLevel::factory(),
                    'status' => $this->faker->randomElement(['active', 'inactive']),
                    'email' => $this->faker->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'remember_token' => Str::random(10),
                ];
            }else{
                return [
                    'name' => $this->faker->name(),
                    'payments_id' => Payment::factory(),
                    'comments_id' => CommentAndCalification::factory(),
                    'bills_id' => Bill::factory(),
                    'providers_id' => null,
                    'user_levels_id' => UserLevel::factory(),
                    'status' => $this->faker->randomElement(['active', 'inactive']),
                    'email' => $this->faker->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'remember_token' => Str::random(10),
                ];
            }

        
    }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
