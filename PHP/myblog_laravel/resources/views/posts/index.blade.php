<!-- テンプレートの読み込み -->
@extends('layouts.default')

<!-- タイトルの設定 -->
@section('title', 'Blog Posts')

<!-- 表示内容の設定 -->
@section('content')
<h1>
  <a href="{{ url('/posts/create') }}" class="header-menu">New Post</a>
  Blog Posts
</h1>
<ul>
  @forelse ($posts as $post)
  <li>
    <a href="{{ action('PostsController@show', $post) }}">{{ $post->title }}</a>
    <a href="{{ action('PostsController@edit', $post) }}" class="edit">[Edit]</a>
    <a href="#" class="del" data-id="{{ $post->id }}">[x]</a>
    <form method="post" action="{{ url('/posts', $post->id) }}" id="form_{{ $post->id }}">
      <!-- CSRF対策 -->
      {{ csrf_field() }}

      <!-- メソッドの指定 -->
      {{ method_field('delete') }}
    </form>
  </li>
  @empty
  <li>No posts yet</li>
  @endforelse
</ul>
<script src="{{ asset('js/main.js') }}"></script>
@endsection
