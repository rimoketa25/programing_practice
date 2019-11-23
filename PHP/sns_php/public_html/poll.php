<?php
// 初期設定
require_once(__DIR__ . '/../config/config.php');

// インスタンス作成
try {
  $uploader = new \MyApp\Controller\ImageUploader();
  $poll = new \MyApp\Controller\Poll();
} catch (Exception $e) {
  echo $e->getMessage();
  exit;
}

// POSTで通信されたら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  switch ($_POST['mode']) {
    case 'upload':
      // 画像のアップロード
      $uploader->upload();
      break;
    case 'delete':
      // 投票結果のリセット
      $poll->postAction();

      // 画像の削除
      $uploader->delete();
      break;
    case 'poll':
      // 投票
      $poll->postAction();
      break;
  }
}

// 実行結果の取得
list($success, $error) = $uploader->getResults();

// 表示する画像一覧の取得
$images = $uploader->getImages();

// エラーの取得
$err = $poll->getError();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Poll</title>
  <link rel="stylesheet" href="css/styles_poll.css">
</head>

<body>
<!-- 画像のアップロード ここから↓ -->
  <!-- アップロードボタン -->
  <div class="btn" id="upload">
    画像の追加
    <!-- ファイルアップロード用のフォームの書き方 -->
    <form action="" method="post" enctype="multipart/form-data" id="upload_form">
      <!-- ファイル入力用フォーム（透明にして非表示） -->
      <input type="file" name="image" id="my_file">
      <!-- ファイルの最大サイズの指定 -->
      <input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE); ?>">
      <!-- トークンの設定 -->
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <!-- 実行モードの指定 -->
      <input type="hidden" name="mode" value="upload">
    </form>
  </div>

  <div class="btn" id="delete">
    画像の削除
    <form action="" method="post" id="delete_form">
      <!-- トークンの設定 -->
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <!-- 実行モードの指定 -->
      <input type="hidden" name="mode" value="delete">
    </form>
  </div>

  <!-- 処理結果メッセージ -->
  <?php if (isset($success)) : ?>
    <div class="msg success"><?= h($success); ?></div>
  <?php endif; ?>
  <?php if (isset($error)) : ?>
    <div class="msg error"><?= h($error); ?></div>
  <?php endif; ?>
<!-- 画像のアップロード ここまで↑ -->

<!-- 投票 ここから↓ -->
  <!-- エラーが発生していれば表示 -->
  <?php if (isset($err)) : ?>
  <div class="error"><?= h($err); ?></div>
  <?php endif; ?>

  <!-- 投票機能 -->
  <h1>どの画像が一番好きですか？</h1>
  <form action="" method="post" id="poll_form">
    <div class="row">
      <!-- 投票対象 -->
      <?php $cnt = 0 ?>
      <?php foreach ($images as $image) : ?>
        <div class="box" id="box_<?= h($cnt); ?>" data-id="<?= h($cnt); ?>">
          <a target="_blank" href="<?= h(basename(IMAGES_DIR)) . '/' . h(basename($image)); ?>">
            <img src="<?= h($image); ?>">
          </a>
          <input type="radio" name="poll" value="<?= h($cnt); ?>">
        </div>
        <?php $cnt++ ?>
      <?php endforeach; ?>

      <!-- 投票した画像の値の設定 -->
      <input type="hidden" id="answer" name="answer" value="">
      <!-- 画像枚数の指定 -->
      <input type="hidden" name="images" value="<?= h($cnt); ?>">
      <!-- トークンの設定 -->
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <!-- 実行モードの指定 -->
      <input type="hidden" name="mode" value="poll">
    </div>

    <!-- 投票・結果確認ボタン -->
    <div class="btn" id="poll">投票して結果の確認</div>
  </form>
<!-- 投票 ここまで↑ -->

  <a href="/">トップ画面に戻る</a>

  <!-- スクリプトファイルの読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/poll.js"></script>
</body>
</html>
