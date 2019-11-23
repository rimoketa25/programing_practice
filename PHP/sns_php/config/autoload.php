<?php
// クラスのオートロード
spl_autoload_register(function($class) {
    // 名前空間の宣言
  $prefix = 'MyApp\\';

  // クラスが指定した名前空間から始まるか判定
  if (strpos($class, $prefix) === 0) {
    // クラス名の取得
    $className = substr($class, strlen($prefix));

    // ファイルパスの指定
    $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';

    // 指定するファイルが存在するか判定
    if (file_exists($classFilePath)) {
      // PHPファイルの読み込み
      require $classFilePath;
    } else {
      echo 'No such class: ' . $className;
      exit;
    }
  }
});
