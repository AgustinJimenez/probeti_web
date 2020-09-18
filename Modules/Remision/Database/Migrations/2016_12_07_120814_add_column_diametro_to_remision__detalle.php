<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDiametroToRemisionDetalle extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remision__detalle', function(Blueprint $table)
        {
            $table->string('diametro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remision__detalle', function(Blueprint $table)
        {
            $table->dropColumn('diametro');
        });
    }

}
