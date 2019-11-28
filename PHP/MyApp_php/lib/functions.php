<?php

// エスケープ用関数
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// トークン作成関数
function create_token() {
  if (!isset($_SESSION['token'])) {
    // 32桁の複雑な文字列をセッションに設定
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
  }
}

// トークン判定関数
function validate_token($tokenKey) {
  if (
    !isset($_SESSION['token']) || // セッションにトークンが設定されていない
    !isset($_POST[$tokenKey]) || // ブラウザからトークンが送信されていない
    $_SESSION['token'] !== $_POST[$tokenKey] // セッションと送られてきたトークンが一致しない
  ) {
    echo "Invalid Token!";
    exit;
  }
}

// デバッグ用関数
function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}
