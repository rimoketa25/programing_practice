<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller {
  // コメントの投稿
  public function store(Request $request, Post $post) {
    // 入力チェック
    $this->validate($request, [
      'body' => 'required'
    ]);

    // インスタンス作成
    $comment = new Comment(['body' => $request->body]);

    // Postに結び付けて投稿
    $post->comments()->save($comment);

    // 元の画面にリダイレクト
    return redirect()->action('PostsController@show', $post);
  }

  // コメントの削除
  public function destroy(Post $post, Comment $comment) {
    // 削除
    $comment->delete();

    // 元の画面にリダイレクト
    return redirect()->back();
  }
}
