<?php

namespace App\Controller;

class CommentsController extends AppController {

  // コメントの投稿
  public function add() {
    // インスタンス作成
    $comment = $this->Comments->newEntity();

    // POSTで通信された時だけ実行
    if ($this->request->is('post')) {
      // リクエストデータの取得
      $comment = $this->Comments->patchEntity($comment, $this->request->data);

      // 投稿
      if ($this->Comments->save($comment)) {
        // 正常終了
        $this->Flash->success('コメントを投稿しました！');
        return $this->redirect(['controller'=>'Posts', 'action'=>'view', $comment->post_id]);
      } else {
        // 異常終了
        $this->Flash->error('コメントの投稿に失敗しました！');
      }
    }

    // 自身に設定
    $this->set(compact('comment'));
  }

  // コメントの削除
  public function delete($id = null) {
    // 受け付ける通信の設定
    $this->request->allowMethod(['post', 'delete']);

    // 指定されたコメントの取得
    $comment = $this->Comments->get($id);

    // 削除
    if ($this->Comments->delete($comment)) {
      // 正常終了
      $this->Flash->success('コメントを削除しました！');
    } else {
      // 異常終了
      $this->Flash->error('コメントの削除に失敗しました！');
    }
    return $this->redirect(['controller'=>'Posts', 'action'=>'view', $comment->post_id]);
  }
}
