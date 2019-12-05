create database myblog_cakephp;
grant all on myblog_cakephp.* to dbuser@localhost identified by '28fa8Iuy';
use myblog_cakephp

create table posts (
  id int unsigned auto_increment primary key,
  title varchar(255),
  body text,
  created datetime default null,
  modified datetime default null
);
insert into posts (title, body, created) values
('title 1', 'body 1', now()),
('title 2', 'body 2', now()),
('title 3', 'body 3', now());
select * from posts;
