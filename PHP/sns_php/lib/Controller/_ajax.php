<?php
// 初期設定
require_once(__DIR__ . '/../config/config.php');

// インスタンス作成
$todoApp = new \MyApp\Controller\TodoApp();

// ajax処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // 処理実行
    $res = $todoApp->post();

    // 結果をJSON形式で返却
    header('Content-Type: application/json');
    echo json_encode($res);
    exit;
  } catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo $e->getMessage();
    exit;
  }
}
