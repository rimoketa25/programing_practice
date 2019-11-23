-- DB作成
drop database if exists myapp_php;
create database myapp_php;

-- 権限の設定
grant all on myapp_php.* to dbuser@localhost identified by 'mu4uJsif';

-- DB変更
use myapp_php

ユーザーテーブルの作成
drop table if exists users;
create table users (
  id int not null auto_increment primary key,
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

-- 確認のための表示
desc users;

-- 投票結果テーブル作成
drop table if exists answers;
create table answers (
  id int not null auto_increment primary key,
  answer int not null,
  created datetime,
  answer_date date,
);

-- 確認のための表示
desc answers;

-- Todoテーブル作成
create table todos (
  id int not null auto_increment primary key,
  state tinyint(1) default 0, /* 0:not finished, 1:finished */
  title text
);

-- 確認のための表示
desc todos;
