<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCiudad extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ciudad', function($table)
		{

		    $table->increments('id');
		    $table->string('nombre_ciudad');
		    $table->boolean('habilitado');
		    $table->smallInteger('zoom');
		    $table->integer('idPartido');
		    $table->integer('idProvincia');
		    $table->integer('idPais');
		    $table->timestamps();

		    // Foreign keys
		    $table->foreign('idPartido')->references('id')->on('partido');
		    $table->foreign('idProvincia')->references('id')->on('Provincia');
		    $table->foreign('idPais')->references('id')->on('Pais');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::$table('ciudad', function($table){

			 $table->dropForeign('ciudad_idPartido_foreign');
			 $table->dropForeign('ciudad_idProvincia_foreign');
			 $table->dropForeign('ciudad_idPais_foreign');

		});

		Schema::dropIfExists('ciudad');
	}

}
