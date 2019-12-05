<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller {
  // トップ画面の表示
  public function index() {
    // 表示内容の取得
    $posts = Post::latest()->get();

    return view('posts.index')->with('posts', $posts);
  }

  // 詳細画面の表示
  public function show(Post $post) {
    return view('posts.show')->with('post', $post);
  }

  // 投稿画面の表示
  public function create() {
    return view('posts.create');
  }

  // 記事の投稿
  public function store(PostRequest $request) {
    // インスタンス作成
    $post = new Post();

    // 値の設定
    $post->title = $request->title;
    $post->body = $request->body;

    // 投稿
    $post->save();

    return redirect('/');
  }

  // 編集画面の表示
  public function edit(Post $post) {
    return view('posts.edit')->with('post', $post);
  }

  // 記事の更新
  public function update(PostRequest $request, Post $post) {
    // 値の設定
    $post->title = $request->title;
    $post->body = $request->body;

    // 更新
    $post->save();

    return redirect('/');
  }

  // 記事の削除
  public function destroy(Post $post) {
    $post->delete();
    return redirect('/');
  }
}
