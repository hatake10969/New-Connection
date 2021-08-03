<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Comment extends Db {
  private $table = 'comments';
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // コメントを作成
  public function createById($arr = ['message' => "", 'user_id' => "", "event_id" => ""]) {
    try {
      $sql = "INSERT INTO comments(message, user_id, event_id) VALUE(:message, :user_id, :event_id)";
      $sth = $this->dbh->prepare($sql);
      // メッセージ
      $sth->bindParam(':message', $arr['message'], PDO::PARAM_STR);
      // ユーザーID（コメント投稿者）
      $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
      // イベントID
      $sth->bindParam(':event_id', $arr['event_id'], PDO::PARAM_INT);
      $result = $sth->execute();
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // 既存のコメント情報とそれに紐づくユーザー情報(名前・アイコン)を全て取得
  public function findById($id) {
    try {
      $sql = "SELECT c.message, u.id, u.nickname, u.icon FROM comments c
              JOIN users u ON c.user_id = u.id WHERE c.event_id = :event_id
              ORDER BY c.created_at";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':event_id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }
}
?>