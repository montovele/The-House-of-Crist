<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('payments_id')->nullable();
            $table->unsignedBigInteger('comments_id')->nullable();
            $table->unsignedBigInteger('bills_id')->nullable();
            $table->unsignedBigInteger('providers_id')->nullable();
            $table->unsignedBigInteger('user_levels_id')->nullable();
            $table->string('status')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('payments_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('comments_id')->references('id')->on('comment_and_califications')->onDelete('cascade');
            $table->foreign('bills_id')->references('id')->on('bills')->onDelete('cascade');
            $table->foreign('providers_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('user_levels_id')->references('id')->on('user_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
