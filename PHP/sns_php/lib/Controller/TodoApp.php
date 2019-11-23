<?php
// 名前空間の指定
namespace MyApp\Controller;

class TodoApp extends \MyApp\Controller {
  // POST処理実行関数
  public function post() {
    // トークン判定
    validate_token('token');

    // インスタンス作成
    $todoModel = new \MyApp\Model\Todo();

    // 実行モードが指定されているか判定
    if (!isset($_POST['mode'])) {
      throw new \Exception('mode not set!');
    }

    // 実行モード判定
    switch ($_POST['mode']) {
      case 'create':
        return $todoModel->create();
      case 'update':
        return $todoModel->update();
      case 'delete':
        return $todoModel->delete();
    }
  }

  // Todoリスト取得関数
  public function getList() {
    // インスタンス作成
    $todoModel = new \MyApp\Model\Todo();

    // Todoリスト取得
    return $todoModel->getAll();
  }
}
