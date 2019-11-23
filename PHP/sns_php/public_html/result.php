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

// 表示する画像一覧の取得
$images = $uploader->getImages();

// 結果の取得
$results = $poll->getResults(count($images));
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Poll Result</title>
  <link rel="stylesheet" href="css/styles_poll.css">
</head>

<body>
  <h1>投票結果 ...</h1>
    <div class="row">
      <!-- 投票対象 -->
      <?php $cnt = 0 ?>
      <?php foreach ($images as $image) : ?>
        <div class="box selected" id="box_<?= h($cnt); ?>" data-id="<? h($cnt); ?>">
          <a href="<?= h(basename(IMAGES_DIR)) . '/' . h(basename($image)); ?>">
            <img src="<?= h($image); ?>">
          </a>
          <p><?= h($results[$cnt]); ?></p>
        </div>
        <?php $cnt++ ?>
      <?php endforeach; ?>
    </div>
    <a href="/poll.php"><div class="btn">投票画面に戻る</div></a>
</body>
</html>
