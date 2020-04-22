<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablePlaces extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('places', function(Blueprint $table)
		{

			$table->integer('iCiudad')->unsigned();

    		$table->foreign('idCiudad')->references('id')->on('ciudad');

		});
	}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	
		Schema::table('places', function(Blueprint $table)
			{

				$table->dropForeign('places_idCiudad_foreign');

			    $table->dropColumn('idCiudad');

			});

	}

}
