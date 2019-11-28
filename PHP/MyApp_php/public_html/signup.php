<?php
// 設定ファイルの読み込み
require_once(__DIR__ . '/../config/config.php');

// インスタンス作成
$app = new MyApp\Controller\Signup();

// 実行
$app->run();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/styles_sns.css">
</head>

<!-- 新規登録画面 -->
<body>
  <div id="container">
    <form action="" method="post" id="signup">
      <!-- メールアドレス入力 -->
      <p>
        <input type="text" name="email" placeholder="メールアドレス" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
      </p>
      <!-- エラーメッセージ表示 -->
      <p class="err">
        <?= h($app->getErrors('email')); ?>
      </p>
      <!-- パスワード入力 -->
      <p>
        <input type="password" name="password" placeholder="パスワード（半角英数字）">
      </p>
      <!-- エラーメッセージ表示 -->
      <p class="err">
        <?= h($app->getErrors('password')); ?>
      </p>
      <!-- 新規登録ボタン -->
      <div class="btn" onclick="document.getElementById('signup').submit();">新規登録</div>
      <!-- ログイン画面へのリンク -->
      <p class="fs12">
        <a href="./login.php">ログイン</a>
      </p>
      <!-- トークン設定 -->
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </div>
</body>
</html>
