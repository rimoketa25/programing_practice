<?php
// 名前空間の指定
namespace MyApp;

class Token {
  // トークン作成関数
  static public function create() {
    if (!isset($_SESSION['token'])) {
      // 32桁の複雑な文字列をセッションに設定
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
  }

  // トークン判定関数
  static public function validate($tokenKey) {
    if (
      !isset($_SESSION['token']) || // セッションにトークンが設定されていない
      !isset($_POST[$tokenKey]) || // ブラウザからトークンが送信されていない
      $_SESSION['token'] !== $_POST[$tokenKey] // セッションと送られてきたトークンが一致しない
    ) {
      throw new \Exception('invalid token!');
    }
  }
}
