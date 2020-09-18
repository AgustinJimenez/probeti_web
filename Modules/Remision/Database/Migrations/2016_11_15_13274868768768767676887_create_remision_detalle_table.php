<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemisionDetalleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remision__detalle', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('numero_probeta');
            $table->date('fecha_moldeo');
            $table->string('dias');
            $table->double('fck', 14, 3);
            $table->integer('remision_id')->unsigned();
            $table->foreign('remision_id')->references('id')->on('remision__remisions')->onDelete('cascade');

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
        Schema::drop('remision_detalle');
    }

}
