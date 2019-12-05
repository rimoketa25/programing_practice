<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// トップページ
Route::get('/', 'PostsController@index');

// 詳細画面
Route::get('/posts/{post}', 'PostsController@show')->where('post', '[0-9]+');

// 記事投稿画面
Route::get('/posts/create', 'PostsController@create');

// 編集画面
Route::get('/posts/{post}/edit', 'PostsController@edit');

// 記事投稿
Route::post('/posts', 'PostsController@store');

// 記事更新
Route::patch('/posts/{post}', 'PostsController@update');

// 記事削除
Route::delete('/posts/{post}', 'PostsController@destroy');

// コメント投稿
Route::post('/posts/{post}/comments', 'CommentsController@store');

// コメント削除
Route::delete('/posts/{post}/comments/{comment}', 'CommentsController@destroy');
