<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRemisionDetalle extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remision__remisions', function(Blueprint $table)
        {
            $table->boolean('estado')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remision__remisions', function(Blueprint $table)
        {
            $table->dropColumn('estado');
        });
    }

}
