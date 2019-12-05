<?php
// タイトルの設定
$this->assign('title', '詳細');
?>

<h1>
  <?= $this->Html->link('一覧に戻る', ['action'=>'index'], ['class'=>['pull-right', 'fs12']]); ?>
  <?= h($post->title); ?>
</h1>

<!-- 本文の表示 -->
<p><?= nl2br(h($post->body)); ?></p>

<!-- コメントがあれば表示 -->
<?php if (count($post->comments)) : ?>
  <h2>コメント <span class="fs12">(<?= count($post->comments); ?>)</span></h2>
  <ul>
  <?php foreach ($post->comments as $comment) : ?>
    <li>
      <!-- コメント内容 -->
      <?= h($comment->body); ?>

      <!-- 削除ボタン -->
      <?=
        $this->Form->postLink(
          '[×]',
          ['controller'=>'Comments', 'action'=>'delete', $comment->id],
          ['confirm'=>'本当に削除してよろしいですか？', 'class'=>'fs12']
        );
      ?>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<h2>コメントの追加</h2>
<!-- フォームの作成 -->
<?= $this->Form->create(null, [
  'url' => ['controller'=>'Comments', 'action'=>'add']
]); ?>
<?= $this->Form->input('body'); ?>
<?= $this->Form->hidden('post_id', ['value'=>$post->id]); ?>
<?= $this->Form->button('追加'); ?>
<?= $this->Form->end(); ?>
