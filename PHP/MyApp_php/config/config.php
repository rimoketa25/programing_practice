<?php

// エラー表示設定
ini_set('display_errors', 1);

// DB接続設定
$dbhost = 'localhost';
$dbname = 'myApp_db';
$dsn = 'mysql:host='.$dbhost.';dbname='.$dbname;
define('DSN', $dsn);
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'joker1118');

// 定数宣言
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . "/PHP/MyApp_php/public_html");
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // ファイルの最大サイズ：1MB
define('THUMBNAIL_WIDTH', 150); // サムネイル画像の幅
define('IMAGES_DIR', __DIR__ . '/../public_html/images'); // アップロード画像の保存パス
define('THUMBNAIL_DIR', __DIR__ . '/../public_html/thumbs'); // サムネイル画像の保存パス


// 汎用関数の読み込み
require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');

// Carbonの読み込み
require '../vendor/autoload.php';

// セッション設定
session_start();
$_SESSION['t'] = null;

// プラグインチェック
if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}
