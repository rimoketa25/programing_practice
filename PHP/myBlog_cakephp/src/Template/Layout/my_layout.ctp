<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset() ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->css('styles.css') ?>
</head>
<body>
    <?= $this->element('my_header') ?>

    <!-- メッセージの表示 -->
    <?= $this->Flash->render() ?>

    <section class="container">
        <!-- テンプレートの読み込み -->
        <?= $this->fetch('content') ?>
    </section>
</body>
</html>
