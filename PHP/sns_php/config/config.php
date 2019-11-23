<?php

// エラー表示設定
ini_set('display_errors', 1);

// DB接続設定
define('DSN', 'mysql:dbhost=localhost;dbname=myapp_php');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'mu4uJsif');

// 定数宣言
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // ファイルの最大サイズ：1MB
define('THUMBNAIL_WIDTH', 150); // サムネイル画像の幅
define('IMAGES_DIR', __DIR__ . '/../public_html/images'); // アップロード画像の保存パス
define('THUMBNAIL_DIR', __DIR__ . '/../public_html/thumbs'); // サムネイル画像の保存パス


// 汎用関数の読み込み
require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');

// セッション設定
session_start();
$_SESSION['t'] = null;

// プラグインチェック
if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}
