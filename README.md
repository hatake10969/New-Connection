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
|id|int|null: false|
|nickname|string|null: false|
|email|string|null: false, unique: true|
|password|string|null: false|
|icon|string|null: false|
|role|int|null: false|

## eventsテーブル
|Column|Type|Options|
|------|----|-------|
|id|int|null: false|
|name|string|null: false|
|content|string|null: false|
|place|string|null: false|
|date|date|null: false|
|time|time|null: false|
|image|string|null: false|
|user_id|int|null: false, foreign_key:true|
|created_at|datetime|

## event_usersテーブル
|Column|Type|Options|
|------|----|-------|
|id|int|null: false|
|user_id|int|null:false, foreign_key: true|
|event_id|int|null:false, foreign_key: true|

## commentsテーブル
|Column|Type|Options|
|------|----|-------|
|id|int|null: false|
|message|string|null: false|
|user_id|int|null:false, foreign_key: true|
|event_id|int|null:false, foreign_key: true|
|created_at|datetime|
