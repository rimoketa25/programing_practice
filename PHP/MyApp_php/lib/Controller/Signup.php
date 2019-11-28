<?php
// 名前空間の設定
namespace MyApp\Controller;

class Signup extends \MyApp\Controller {
  // 実行関数
  public function run() {
    // ログイン済みか判定
    if ($this->isLoggedIn()) {
      // ログインしていればユーザー一覧画面にリダイレクト
      header('Location: ' . SITE_URL);
      exit;
    }

    // POSTで通信されたら処理実行
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  // 通信処理実行関数
  protected function postProcess() {
    // 入力チェック
    try {
      $this->_validate();
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    }

    // 入力値の設定
    $this->setValues('email', $_POST['email']);

    if ($this->hasError()) {
      // エラーが発生していれば処理終了
      return;
    } else {
      try {
        // インスタンス作成
        $userModel = new \MyApp\Model\User();

        // 新規登録
        $userModel->create([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }

      // ログイン画面にリダイレクト
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
  }

  // 入力チェック関数
  private function _validate() {
    // トークン
    validate_token('token');

    // メールアドレス
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }

    // パスワード
    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }
}
