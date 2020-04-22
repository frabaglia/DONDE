<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {

	  protected $table = 'question';
    public $timestamps = false;

    public function options()
   {
       return $this->hasMany('App\QuestionOption');
   }

	 public function services()
  {
	 return $this->belongsToMany('App\Service', 'question_service', 'question_id', 'service_id');
 	}
}
