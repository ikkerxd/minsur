<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_type_course')->unsigned();
            $table->string('name',100);
            $table->integer('hh');
            $table->integer('module');
            $table->decimal('amount', 9, 2);
            $table->integer('state');
            $table->timestamps();

            $table->foreign('id_type_course')->references('id')->on('type_courses')
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
        Schema::dropIfExists('courses');
    }
}
