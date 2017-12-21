<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {

  protected $table = 'service';
  public $timestamps = false;

  public function questions()
  {
    return $this->belongsToMany('App\Question', 'question_service', 'service_id', 'question_id');
  }
}
