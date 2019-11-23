<?php
// 名前空間の指定
namespace MyApp;

class Quiz {
  // プロパティ宣言
  private $_quizSet = [];

  // コンストラクター
  public function __construct() {
    // クイズの作成
    $this->_setup();

    // トークンの設定
    Token::create();

    // セッションの初期化
    if (!isset($_SESSION['current_num'])) {
      $this->_initSession();
    }
  }

  // クイズ作成関数
  private function _setup() {
    $this->_quizSet[] = [
      'q' => 'What is A?',
      'a' => ['A0', 'A1', 'A2', 'A3']
    ];
    $this->_quizSet[] = [
      'q' => 'What is B?',
      'a' => ['B0', 'B1', 'B2', 'B3']
    ];
    $this->_quizSet[] = [
      'q' => 'What is C?',
      'a' => ['C0', 'C1', 'C2', 'C3']
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
    Token::validate('token');

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
