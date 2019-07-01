<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_course')->unsigned();
            $table->integer('id_location')->unsigned();
            $table->datetime('startDate');
            $table->datetime('endDate');
            $table->string('address',100);
            $table->string('time',10);
            $table->integer('slot');
            $table->text('note');
            $table->integer('type');
            $table->integer('state');
            $table->timestamps();

            $table->foreign('id_course')->references('id')->on('courses')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('id_location')->references('id')->on('locations')
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
        Schema::dropIfExists('inscriptions');
    }
}
