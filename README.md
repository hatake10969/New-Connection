# README

# 💻 Project Title
## *New-Connection*
![](https://i.gyazo.com/8f99428aad62b32c2c7bf44ee40cec22.jpg)

# 💬 Description
  イベント情報集約サイトです。
  誰でも簡単にイベントの作成・応募をすることができます。
  開発言語：haml,scss,JavaScript,PHP

# 🎨 DataBase Disign
## usersテーブル
|Column|Type|Options|
|------|----|-------|
|id|int|notnull|
|nickname|string|notnull|
|email|string|notnull, unique: true|
|password|string|notnull|
|icon|string|notnull|
|role|int|notnull|

## eventsテーブル
|Column|Type|Options|
|------|----|-------|
|id|int|notnull|
|name|string|notnull|
|content|string|notnull|
|place|string|notnull|
|date|date|notnull|
|time|time|notnull|
|image|string|notnull|
|user_id|int|notnull, foreign_key:true|
|created_at|datetime|notnull|

## event_usersテーブル
|Column|Type|Options|
|------|----|-------|
|id|int|notnull|
|user_id|int|notnull, foreign_key: true|
|event_id|int|notnull, foreign_key: true|

## commentsテーブル
|Column|Type|Options|
|------|----|-------|
|id|int|notnull|
|message|string|notnull|
|user_id|int|notnull, foreign_key: true|
|event_id|int|notnull, foreign_key: true|
|created_at|datetime|notnull|
