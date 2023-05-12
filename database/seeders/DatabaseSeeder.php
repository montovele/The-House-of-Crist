<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Bill::factory(3)->create();
        \App\Models\CommentAndCalification::factory(3)->create();
        \App\Models\Payment::factory(3)->create();
        \App\Models\Product::factory(5)->create();
        \App\Models\ProviderPayment::factory(3)->create();
        \App\Models\Reservation::factory(3)->create();
        \App\Models\Service::factory(5)->create();
        \App\Models\Provider::factory(3)->create();
        \App\Models\UserLevel::factory(1)->create();
        \App\Models\User::factory(3)->create();
        \App\Models\FinancialTransaction::factory(3)->create();
        \App\Models\Action::factory(3)->create();
    }
}
