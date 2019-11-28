<?php
// 初期設定
require_once(__DIR__ . '/../config/config.php');

// インスタンス作成
$cal = new \MyApp\Controller\Calendar();
$todoApp = new \MyApp\Controller\TodoApp();

// POSTで通信されたら
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $cal = new \MyApp\Controller\Calendar();
}

// Todoリストの取得
$todos = $todoApp->getList();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" href="css/styles_calendar.css">
</head>

<body>
<!-- カレンダー ここから↓ -->
  <table>
    <thead>
      <tr>
        <form class="change_form" action="" method="get">
          <th><a class="link" name="<?= h($cal->prev); ?>">&laquo;</a></th>
          <th colspan="5">
            <select id="year" class="list">
              <?php for($i = 1980; $i < 2031; $i++) { ?>
                <option value="<?= $i ?>" <?php if ($i == $cal->year) { echo 'selected'; } ?>><?= $i ?>年</option>
              <?php } ?>
            </select>
            <select id="month" class="list">
              <?php for($i = 1; $i < 13; $i++) { ?>
                <option value="<?= $i ?>" <?php if ($i == $cal->month) { echo 'selected'; } ?>><?= $i ?>月</option>
              <?php } ?>
            </select>
          <th><a class="link" name="<?= h($cal->next); ?>">&raquo;</a></th>
          <input type="hidden" id="tValue" name="t" value="">
        </form>
      </tr>
    </thead>
    <tbody id="calendar">
      <?= $cal->show(); ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="7"><a id="link" href="./calendar.php">Today</a></th>
      </tr>
    </tfoot>
  </table>
<!-- カレンダー ここまで↑ -->

<!-- Todoリスト ここから↓ -->
  <div id="container">
    <h1>Todos</h1>

    <!-- Todo作成 -->
    <form action="" id="new_todo_form">
      <input type="text" id="new_todo" placeholder="What needs to be done?">
    </form>

    <!-- Todoリスト -->
    <ul id="todos">
    <?php foreach ($todos as $todo) : ?>
      <li id="todo_<?= h($todo->id); ?>" data-id="<?= h($todo->id); ?>">
        <input type="checkbox" class="update_todo" <?php if ($todo->state === '1') { echo 'checked'; } ?>>
        <span class="todo_title <?php if ($todo->state === '1') { echo 'done'; } ?>"><?= h($todo->title); ?></span>
        <div class="delete_todo">x</div>
      </li>
    <?php endforeach; ?>
      <li id="todo_template" data-id="">
        <input type="checkbox" class="update_todo">
        <span class="todo_title"></span>
        <div class="delete_todo">x</div>
      </li>
    </ul>
  </div>

  <!-- トークンの設定 -->
  <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">

  <!-- スクリプト読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="js/calendar.js"></script>
<!-- Todoリスト ここまで↑ -->

</body>
</html>
