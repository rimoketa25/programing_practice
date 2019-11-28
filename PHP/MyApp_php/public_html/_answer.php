<?php
// 初期設定
require_once(__DIR__ . '/../config/config.php');

// インスタンス作成
$quiz = new MyApp\Controller\Quiz();

try {
  // 正誤判定
  $correctAnswer = $quiz->checkAnswer();
} catch (Exception $e) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden', true, 403);
  echo $e->getMessage();
  exit;
}

// JSONの返却
header('Content-Type: application/json; charset=UTF-8');
echo json_encode([
  'correct_answer' => $correctAnswer
]);
