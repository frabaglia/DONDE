<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnstoevaluation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('evaluation', function(Blueprint $table)
		{
			 $table->boolean('es_gratuito');
			 $table->boolean('comodo');
			 $table->boolean('informacion_vacunas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('evaluation', function(Blueprint $table)
		{
			//
		});
	}

}
