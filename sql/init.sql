create database if not exists forum;
use forum;
create table if not exists users(
	user_id binary(16) not null default (UUID_TO_BIN(UUID())),
	name varchar(64) not null,
	password text not null,
	join_date datetime not null default (CURRENT_TIMESTAMP),
	avatar varchar(1024), -- 1024 is PATH_MAX?
	primary key (user_id),
  unique (name)
);

create table if not exists topics(
	topic_id binary(16) not null default (UUID_TO_BIN(UUID())),
	author_id binary(16) not null references users(user_id),
	title varchar(256) not null,
	creation_date datetime not null default (CURRENT_TIMESTAMP),
	primary key (topic_id),
  unique (title)
);

create table if not exists messages(
	message_id binary(16) not null default (UUID_TO_BIN(UUID())),
	topic_id binary(16) not null references topics(topic_id),
	author_id binary(16) not null references users(user_id),
	text text not null,
	creation_date datetime not null default (CURRENT_TIMESTAMP),
	primary key (message_id)
);

delimiter $$

drop procedure if exists register_user$$
create procedure register_user(input_name text, input_password text)
begin
  insert into users (name, password) values (input_name, input_password);
  select BIN_TO_UUID(user_id) from users where name = input_name;
end$$

drop procedure if exists fetch_login$$
create procedure fetch_login(input_name text)
begin
  select BIN_TO_UUID(user_id), password from users where name = input_name;
end$$

drop procedure if exists create_topic$$
create procedure create_topic(input_title text, input_author text, input_message text)
begin
  set @input_author_id = UUID_TO_BIN(input_author);
  insert into topics (title, author_id) values (input_title, @input_author_id);
  set @id = (select topic_id from topics where title = input_title);
  insert into messages (topic_id, author_id, text) values (@id, @input_author_id, input_message);
  select BIN_TO_UUID(@id);
end$$

drop procedure if exists create_message$$
create procedure create_message(input_topic text, input_author text, input_message text)
begin
  set @input_topic_id = UUID_TO_BIN(input_topic);
  set @input_author_id = UUID_TO_BIN(input_author);
  insert into messages (topic_id, author_id, text) values (@input_topic_id, @input_author_id, input_message);
  select BIN_TO_UUID(message_id) from messages where topic_id = @input_topic_id and author_id = @input_author_id order by creation_date;
end$$

drop procedure if exists get_topics$$
create procedure get_topics()
begin
  select BIN_TO_UUID(topics.topic_id), BIN_TO_UUID(topics.author_id), topics.title, users.name as author, topics.creation_date
  from topics
  inner join users on (topics.author_id = users.user_id)
  order by topics.creation_date desc;
end$$

drop procedure if exists get_topic$$
create procedure get_topic(input_topic text)
begin
  set @input_topic_id = UUID_TO_BIN(input_topic);
  select BIN_TO_UUID(topics.author_id), topics.title, users.name as author, topics.creation_date
  from topics
  inner join users on (topics.author_id = users.user_id)
  where topics.topic_id = @input_topic_id;
end$$

drop procedure if exists get_messages$$
create procedure get_messages(input_topic text)
begin
  set @input_topic_id = UUID_TO_BIN(input_topic);
  select BIN_TO_UUID(messages.message_id), BIN_TO_UUID(messages.author_id), users.name as author, messages.text, messages.creation_date
  from messages
  inner join users on (messages.author_id = users.user_id)
  where messages.topic_id = @input_topic_id
  order by messages.creation_date;
end$$

drop procedure if exists get_user$$
create procedure get_user(input_user text)
begin
  set @input_user_id = UUID_TO_BIN(input_user);
  select user_id, name, join_date, avatar from users where user_id = @input_user_id;
end$$

drop procedure if exists get_post_count$$
create procedure get_post_count(input_user text)
begin
  set @input_user_id = UUID_TO_BIN(input_user);
  set @result = (select count(*) from messages where author_id = @input_user_id);
  select @result;
end$$

delimiter ;
