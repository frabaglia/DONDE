<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model {

	  protected $table = 'answer_option';
    public $timestamps = false;

    public function question()
   {
       return $this->belongsTo('App\Question');
   }
}
