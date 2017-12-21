<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	 public function up()
	 	{
	 		Schema::create('question_service', function(Blueprint $table)
	 		{
	 			$table->increments('id');
	 			$table->integer('question_id')->unsigned();
	 			$table->foreign('question_id')->references('id')->on('question');
	 			$table->integer('service_id')->unsigned();
	 			$table->foreign('service_id')->references('id')->on('service');
	 			//$table->string('service');
	 		//	$table->timestamps();
	 		});
	 	}

	 	/**
	 	 * Reverse the migrations.
	 	 *
	 	 * @return void
	 	 */
	 	public function down()
	 	{
	 		Schema::drop('question_service');
	 	}

}
