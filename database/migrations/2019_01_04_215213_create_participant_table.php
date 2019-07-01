<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user_inscription')->unsigned();
            $table->string('firstLastName');
            $table->string('secondLastName');
            $table->string('name');
            $table->string('dni');
            $table->string('position');
            $table->string('company');
            $table->string('anexo');
            $table->string('duplicate');
            $table->string('condition');
            $table->string('obs');
            $table->integer('state');
            $table->text('obs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
