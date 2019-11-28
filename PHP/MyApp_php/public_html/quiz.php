<?php
// 設定ファイルの読み込み
require_once(__DIR__ . '/../config/config.php');

// インスタンス作成
$quiz = new MyApp\Controller\Quiz();

// クイズが終わるまで問題の表示
if (!$quiz->isFinished()) {
  // 表示する問題の取得
  $data = $quiz->getCurrentQuiz();

  // 選択肢のシャッフル
  shuffle($data['a']);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Quiz</title>
  <link rel="stylesheet" href="css/styles_quiz.css">
</head>
<body>
  <?php if ($quiz->isFinished()) : ?>
    <!-- クイズが終了すれば結果画面の表示 -->
    <div id="container">
      <div id="result">
        Your score ...
        <div><?= h($quiz->getScore()); ?> %</div>
      </div>
      <a href=""><div id="btn">Replay?</div></a>
    </div>
    <?php $quiz->reset(); ?>
  <?php else : ?>
    <!-- 終わるまでは問題の表示 -->
    <div id="container">
      <!-- 問題文 -->
      <h1>Q. <?= h($data['q']); ?></h1>
      <!-- 選択肢 -->
      <ul>
        <?php foreach ($data['a'] as $a) : ?>
          <li class="answer"><?= h($a); ?></li>
        <?php endforeach; ?>
      </ul>
      <!-- ボタン -->
      <div id="btn" class="disabled"><?= $quiz->isLast() ? 'Show Result' : 'Next Question'; ?></div>
      <!-- トークンの設定 -->
      <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/quiz.js"></script>
  <?php endif; ?>
</body>
</html>
