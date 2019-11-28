<?php
// 名前空間の指定
namespace MyApp\Controller;

class Poll extends \MyApp\Controller {
  // 処理実行関数
  public function postAction() {
    try {
      // トークン判定
      validate_token('token');

      // インスタンス作成
      $answerModel = new \MyApp\Model\Answer();

      if ($_POST['mode'] === 'poll'){
        // 入力チェック
        $this->_validateAnswer();

        // 投票結果の保存
        $answerModel->save();

        // 結果画面へのリダイレクト処理
        header('Location: ' . SITE_URL . '/result.php');
        exit;
      } else if($_POST['mode'] === 'delete') {
        // 投票結果のリセット
        $answerModel->reset();
      }
    } catch (\Exception $e) {
      // エラー設定
      $_SESSION['err'] = $e->getMessage();

      // 元の画面へのリダイレクト処理
      header('Location: ' . SITE_URL . '/poll.php');
      exit;
    }
  }

  // 入力チェック関数
  private function _validateAnswer() {
    for ($i = 0; $i < $_POST['images']; $i++) {
      $answers[] = $i;
    }
    // var_dump($answers);
    // exit;

    if (
      !isset($_POST['answer']) ||
      !in_array($_POST['answer'], $answers)
    ) {
      throw new \Exception('投票対象が設定されていません。');
    }
  }

  // 結果取得関数
  public function getResults($cnt) {
    $data = array_fill(0, $cnt, 0);

    // インスタンス作成
    $answerModel = new \MyApp\Model\Answer();

    return $answerModel->getALL($data);
  }

  // エラー取得関数
  public function getError() {
    $err = null;

    // エラーの取得
    if (isset($_SESSION['err'])) {
      // 保持して、セッションのリセット
      $err = $_SESSION['err'];
      unset($_SESSION['err']);
    }

    return $err;
  }
}
