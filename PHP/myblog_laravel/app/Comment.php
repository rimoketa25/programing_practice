<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  //Mass Assignmentの設定
  protected $fillable = ['body'];

  // Postとの結び付け
  public function post() {
    return $this->belongsTo('App\Post');
  }
}
