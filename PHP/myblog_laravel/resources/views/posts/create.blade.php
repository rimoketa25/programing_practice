<!-- テンプレートの読み込み -->
@extends('layouts.default')

<!-- タイトルの設定 -->
@section('title', 'New Post')

<!-- 表示内容の設定 -->
@section('content')
<h1>
  <a href="{{ url('/') }}" class="header-menu">Back</a>
  New Post
</h1>
<!-- 投稿用のフォーム -->
<form method="post" action="{{ url('/posts') }}">
  <!-- CSRF対策 -->
  {{ csrf_field() }}
  <p>
    <input type="text" name="title" placeholder="enter title" value="{{ old('title') }}">
    <!-- 入力エラーの表示 -->
    @if ($errors->has('title'))
    <span class="error">{{ $errors->first('title') }}</span>
    @endif
  </p>
  <p>
    <textarea name="body" placeholder="enter body">{{ old('body') }}</textarea>
    <!-- 入力エラーの表示 -->
    @if ($errors->has('body'))
    <span class="error">{{ $errors->first('body') }}</span>
    @endif
  </p>
  <p>
    <input type="submit" value="Add">
  </p>
</form>
@endsection
