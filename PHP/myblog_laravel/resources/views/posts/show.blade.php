<!-- テンプレートの読み込み -->
@extends('layouts.default')

<!-- タイトルの設定 -->
@section('title', $post->title)

<!-- 表示内容の設定 -->
@section('content')
<h1>
  <a href="{{ url('/') }}" class="header-menu">Back</a>
  {{ $post->title }}
</h1>
<p>{!! nl2br(e($post->body)) !!}</p>

<h2>Comments</h2>
<ul>
  @forelse ($post->comments as $comment)
  <li>
    {{ $comment->body }}
    <a href="#" class="del" data-id="{{ $comment->id }}">[x]</a>
    <!-- 削除用のフォーム -->
    <form method="post" action="{{ action('CommentsController@destroy', [$post, $comment]) }}" id="form_{{ $comment->id }}">
      <!-- CSRF対策 -->
      {{ csrf_field() }}

      <!-- メソッドの指定 -->
      {{ method_field('delete') }}
    </form>
  </li>
  @empty
  <li>No comments yet</li>
  @endforelse
</ul>
<!-- 投稿用のフォーム -->
<form method="post" action="{{ action('CommentsController@store', $post) }}">
  <!-- CSRF対策 -->
  {{ csrf_field() }}
  <p>
    <input type="text" name="body" placeholder="enter comment" value="{{ old('body') }}">
    <!-- 入力エラーの表示 -->
    @if ($errors->has('body'))
    <span class="error">{{ $errors->first('body') }}</span>
    @endif
  </p>
  <p>
    <input type="submit" value="Add Comment">
  </p>
</form>
<script src="/js/main.js"></script>
@endsection
