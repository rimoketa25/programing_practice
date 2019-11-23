<?php
// 名前空間の指定
namespace MyApp;

class Model {
  protected $db;

  // コンストラクター
  public function __construct() {
    // DB接続
    try {
      $this->db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
}
