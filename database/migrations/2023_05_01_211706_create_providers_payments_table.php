<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // pagos a proveedores registra los pagos 
        // realizados a cada factura específica.
        Schema::create('provider_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('providers_id')->nullable();
            $table->unsignedBigInteger('bills_id')->nullable();
            $table->float('payment_amount');
            $table->timestamps();
            $table->foreign('providers_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('bills_id')->references('id')->on('bills')->onDelete('cascade');
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_payments');
    }
}
