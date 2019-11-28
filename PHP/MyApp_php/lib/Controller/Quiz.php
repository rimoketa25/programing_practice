<?php
// 名前空間の指定
namespace MyApp\Controller;

class Quiz extends \MyApp\Controller {
  // プロパティ宣言
  private $_quizSet = [];

  // コンストラクター
  public function __construct() {
    // クイズの作成
    $this->_setup();

    // トークンの設定
    create_token();

    // セッションの初期化
    if (!isset($_SESSION['current_num'])) {
      $this->_initSession();
    }
  }

  // クイズ作成関数
  private function _setup() {
    $this->_quizSet[] = [
      'q' => '都道府県は全部でいくつあるか？',
      'a' => ['47', '46', '48', '49']
    ];
    $this->_quizSet[] = [
      'q' => '一番大きい県はどこか？',
      'a' => ['岩手県', '福島県', '長野県', '新潟県']
    ];
    $this->_quizSet[] = [
      'q' => '一番小さい都府県はどこか？',
      'a' => ['香川県', '大阪府', '東京都', '沖縄県']
    ];
  }

  // セッション初期化関数
  private function _initSession() {
    $_SESSION['current_num'] = 0;
    $_SESSION['correct_count'] = 0;
  }

  // 正誤判定関数
  public function checkAnswer() {
    // トークン判定
    validate_token('token');

    // 正解の取得
    $correctAnswer = $this->_quizSet[$_SESSION['current_num']]['a'][0];

    // 正解が送信されているか判定
    if (!isset($_POST['answer'])) {
      throw new \Exception('answer not set!');
    }

    // 正誤判定
    if ($correctAnswer === $_POST['answer']) {
      $_SESSION['correct_count']++;
    }

    // 問題の更新
    $_SESSION['current_num']++;

    // 正解の返却
    return $correctAnswer;
  }

  // 正答率取得関数
  public function getScore() {
    return round($_SESSION['correct_count'] / count($this->_quizSet) * 100);
  }

  // 現在の問題取得関数
  public function getCurrentQuiz() {
    return $this->_quizSet[$_SESSION['current_num']];
  }

  // 再実行用関数
  public function reset() {
    $this->_initSession();
  }

  // クイズ終了判定関数
  public function isFinished() {
    return count($this->_quizSet) === $_SESSION['current_num'];
  }

  // 最終問題判定関数
  public function isLast() {
    return count($this->_quizSet) === $_SESSION['current_num'] + 1;
  }
}
