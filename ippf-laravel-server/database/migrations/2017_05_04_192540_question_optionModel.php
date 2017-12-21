<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionOptionModel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answer_option', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('body');
			$table->integer('question_id')->unsigned();
			$table->foreign('question_id')->references('id')->on('question');
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
		Schema::drop('answer_option');
	}

}
