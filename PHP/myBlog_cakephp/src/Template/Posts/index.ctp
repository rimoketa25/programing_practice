<?php
// タイトルの設定
$this->assign('title', 'ブログ一覧');
?>

<h1>
  <?= $this->Html->link('ブログの投稿', ['action'=>'add'], ['class'=>['pull-right', 'fs12']]); ?>
  CakePHPで作るブログページ
</h1>

<ul>
  <?php foreach ($posts as $post) : ?>
    <li>
      <!-- 詳細画面へのリンク -->
      <?= $this->Html->link($post->title, ['action'=>'view', $post->id]); ?>

      <!-- 編集画面へのリンク -->
      <?= $this->Html->link('[編集]', ['action'=>'edit', $post->id], ['class'=>'fs12']); ?>

      <!-- 削除ボタン -->
      <?=
        $this->Form->postLink(
          '[×]',
          ['action'=>'delete', $post->id],
          ['confirm'=>'本当に削除してよろしいですか?', 'class'=>'fs12']
        );
      ?>
    </li>
  <?php endforeach; ?>
</ul>
