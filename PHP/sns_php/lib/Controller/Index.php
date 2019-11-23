<?php
// 名前空間の設定
namespace MyApp\Controller;

class Index extends \MyApp\Controller {
  // 実行関数
  public function run() {
    // ログイン済みか判定
    if (!$this->isLoggedIn()) {
      // ログインしていなければログイン画面にリダイレクト
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }

    // インスタンス作成
    $userModel = new \MyApp\Model\User();

    // ユーザー一覧の取得
    $this->setValues('users', $userModel->findAll());
  }
}
