<?php
// タイトルの設定
$this->assign('title', '新規投稿');
?>

<h1>
  <?= $this->Html->link('一覧に戻る', ['action'=>'index'], ['class'=>['pull-right', 'fs12']]); ?>
  新規投稿画面
</h1>

<!-- フォームの作成 -->
<?= $this->Form->create($post); ?>
<?= $this->Form->input('title'); ?>
<?= $this->Form->input('body', ['rows'=>'3']); ?>
<?= $this->Form->button('投稿'); ?>
<?= $this->Form->end(); ?>
