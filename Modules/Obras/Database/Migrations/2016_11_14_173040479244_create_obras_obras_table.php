<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObrasObrasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('obras__obras', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre');
            $table->string('ubicacion');
            $table->string('residente');
            $table->string('observacion');
            $table->boolean('activo')->default(true);

            $table->integer('cliente_id')->unsigned();

            $table->foreign('cliente_id')->references('id')->on('clientes__clientes')->onDelete('cascade');
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
		Schema::drop('obras__obras');
	}
}
