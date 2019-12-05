<?php

namespace App\Controller;

class PostsController extends AppController {

  // 一覧の表示
  public function index() {
    // 表示内容の取得
    $posts = $this->Posts->find('all');

    // 自身に設定
    $this->set(compact('posts'));
  }

  // 詳細の表示
  public function view($id = null) {
    // 指定された投稿の取得
    $post = $this->Posts->get($id, [
      // コメントも同時に取得
      'contain' => 'Comments'
    ]);

    // 自身に設定
    $this->set(compact('post'));
  }

  // ブログの投稿
  public function add() {
    // インスタンス作成
    $post = $this->Posts->newEntity();

    // POSTで通信された時だけ実行
    if ($this->request->is('post')) {
      // リクエストデータの取得
      $post = $this->Posts->patchEntity($post, $this->request->data);

      // 投稿
      if ($this->Posts->save($post)) {
        // 正常終了
        $this->Flash->success('ブログを投稿しました！');
        return $this->redirect(['action'=>'index']);
      } else {
        // 異常終了
        $this->Flash->error('ブログの投稿に失敗しました！');
      }
    }

    // 自身に設定
    $this->set(compact('post'));
  }

  // ブログの更新
  public function edit($id = null) {
    // 指定された投稿の取得
    $post = $this->Posts->get($id);

    // POST、PATC、PUTで通信された時だけ実行
    if ($this->request->is(['post', 'patch', 'put'])) {
      // リクエストデータの取得
      $post = $this->Posts->patchEntity($post, $this->request->data);

      // 更新
      if ($this->Posts->save($post)) {
        // 正常終了
        $this->Flash->success('ブログを更新しました！');
        return $this->redirect(['action'=>'index']);
      } else {
        // 異常終了
        $this->Flash->error('ブログの更新に失敗しました！');
      }
    }

    // 自身に設定
    $this->set(compact('post'));
  }

  // ブログの削除
  public function delete($id = null) {
    // 受け付ける通信の設定
    $this->request->allowMethod(['post', 'delete']);

    // 指定された投稿の取得
    $post = $this->Posts->get($id);

    // 削除
    if ($this->Posts->delete($post)) {
      // 正常終了
      $this->Flash->success('ブログを削除しました！');
    } else {
      // 異常終了
      $this->Flash->error('ブログの削除に失敗しました！');
    }
    return $this->redirect(['action'=>'index']);
  }
}
