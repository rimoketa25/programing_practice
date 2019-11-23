<?php
// 設定ファイルの読み込み
require_once(__DIR__ . '/../config/config.php');

// インスタンス作成
$app = new MyApp\Controller\Index();

// 実行
$app->run();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Home</title>
  <link rel="stylesheet" href="css/styles_sns.css">
</head>

<!-- ユーザー一覧表示画面 -->
<body>
  <div id="container">
    <!-- ログアウトボタン -->
    <form action="logout.php" method="post" id="logout">
      <?= h($app->me()->email); ?> <input type="submit" value="Log Out">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>

    <h1>ユーザー一覧 <span class="fs12">(<?= count($app->getValues()->users); ?>)</span></h1>
    <ul>
      <?php foreach ($app->getValues()->users as $user) : ?>
        <li><?= h($user->email); ?></li>
      <?php endforeach; ?>
    </ul>
    <a href="/poll.php">投票画面</a>
    <a href="/calendar.php">カレンダー</a>
  </div>
</body>
</html>
