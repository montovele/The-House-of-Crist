<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Contiene la información básica de los proveedores
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider_name');
            $table->unsignedBigInteger('services_id')->nullable();
            $table->unsignedBigInteger('products_id')->nullable();
            $table->unsignedBigInteger('providers_payment_id')->nullable();
            $table->unsignedBigInteger('reservations_id')->nullable();
            $table->string('phone_number');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('address');
            $table->string('rfc');
            $table->string('bank_acount');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('services_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('reservations_id')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
