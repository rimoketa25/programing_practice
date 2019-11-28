<?php
// 設定ファイルの読み込み
require_once(__DIR__ . '/../config/config.php');

// POSTで通信が実行されたら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // トークン判定
  validate_token('token');

  // セッション内の値のリセット
  $_SESSION = [];

  // cookieのリセット
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
  }

  // セッションの破棄
  session_destroy();
}

// リダイレクト処理
header('Location: ' . SITE_URL . "/index.php");
