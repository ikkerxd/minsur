<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_inscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_inscription')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->string('service_order');
            $table->integer('quantity');
            $table->string('voucher');
            $table->text('voucher_hash');
            $table->string('payment_form');
            $table->integer('payment_condition');
            $table->integer('state');
            $table->timestamps();

            $table->foreign('id_inscription')->references('id')->on('inscriptions')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');

            $table->foreign('id_user')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_inscriptions');
    }
}
