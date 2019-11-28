<?php
// 名前空間の設定
namespace MyApp\Model;

class User extends \MyApp\Model {
  // 新規登録関数
  public function create($values) {
    // SQL作成
    $stmt = $this->db->prepare(
      "insert into users (email, password, created, modified)
      values (:email, :password, now(), now())"
    );

    // SQL実行
    $res = $stmt->execute([
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);

    // 実行結果判定
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  // ログイン関数
  public function login($values) {
    // SQL作成
    $stmt = $this->db->prepare(
      "select * from users
      where email = :email"
    );

    // SQL実行
    $stmt->execute([
      ':email' => $values['email']
    ]);

    // 実行結果取得
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    // 結果判定
    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    // パスワード突合
    if (!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    return $user;
  }

  // ユーザー一覧取得
  public function findAll() {
    // SQL作成
    $stmt = $this->db->query(
      "select * from users
      order by id"
    );

    // SQL実行
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    
    return $stmt->fetchAll();
  }
}
