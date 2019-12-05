<?php
// タイトルの設定
$this->assign('title', '編集');
?>

<h1>
  <?= $this->Html->link('一覧に戻る', ['action'=>'index'], ['class'=>['pull-right', 'fs12']]); ?>
  編集画面
</h1>

<!-- フォームの作成 -->
<?= $this->Form->create($post); ?>
<?= $this->Form->control('title'); ?>
<?= $this->Form->control('body', ['rows'=>'3']); ?>
<?= $this->Form->button('更新'); ?>
<?= $this->Form->end(); ?>
