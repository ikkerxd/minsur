<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotochecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotochecks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->json('courses')->nullable();
            $table->datetime('date_emited')->nullable();
            $table->string('state',1)->default(\App\Fotocheck::SOLICITED);//0-no_solicitado,//1-solicitado,//2-pendiente
            $table->timestamps();                                               //3-aprobado,//4-cancelado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fotochecks');
    }
}
