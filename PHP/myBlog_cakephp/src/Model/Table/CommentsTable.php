<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CommentsTable extends Table {
  // 初期化
  public function initialize(array $config) {
    $this->addBehavior('Timestamp');

    // Postとの結び付け
    $this->belongsTo('Posts');
  }

  // 入力チェック
  public function validationDefault(Validator $validator) {
    $validator
      ->notEmpty('body')
      ->requirePresence('body');
    return $validator;
  }
}
