<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PostsTable extends Table {
  // 初期化
  public function initialize(array $config) {
    $this->addBehavior('Timestamp');

    // Commentとの結び付け
    $this->hasMany('Comments', [
      // 依存関係の設定
      'dependent' => true
    ]);
  }

  // 入力チェック
  public function validationDefault(Validator $validator) {
    $validator
      ->notEmpty('title')
      ->requirePresence('title')
      ->notEmpty('body')
      ->requirePresence('body')
      ->add('body', [
        'length' => [
          'rule' => ['minLength', 10],
          'message' => 'body length must be 10+'
        ]
      ]);
    return $validator;
  }
}
