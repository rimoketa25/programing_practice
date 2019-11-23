<?php
// 名前空間の設定
namespace MyApp\Controller;

class Login extends \MyApp\Controller {
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
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('login', $e->getMessage());
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

        // ログイン処理
        $user = $userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\UnmatchEmailOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }

      // セッションIDの再作成
      session_regenerate_id(true);
      $_SESSION['me'] = $user;

      // ユーザー一覧画面へリダイレクト
      header('Location: ' . SITE_URL);
      exit;
    }
  }

  private function _validate() {
    // トークン
    validate_token('token');

    // メールアドレス、パスワード
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
      echo "Invalid Form!";
      exit;
    }

    if ($_POST['email'] === '' || $_POST['password'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
  }

}
