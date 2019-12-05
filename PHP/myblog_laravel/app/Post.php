<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  //Mass Assignmentの設定
  protected $fillable = ['title', 'body'];

  // Commentとの結び付け
  public function comments() {
    return $this->hasMany('App\Comment');
  }
}
