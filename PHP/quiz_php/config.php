<?php
// エラー表示の設定
ini_set('display_errors', 1);

// セッションの設定
session_start();

// 汎用関数の読み込み
require_once(__DIR__ . '/functions.php');

// クラスのオートロード設定
require_once(__DIR__ . '/autoload.php');
