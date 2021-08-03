<?php
require_once(ROOT_PATH . '/Models/Db.php');

class EventUser extends Db {
  private $table = 'event_users';
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // 応募時にユーザーIDとイベントIDを紐付けて保存
  public function createById($arr = ['user_id' => "", 'event_id' => ""]) {
    try {
      $sql = "INSERT INTO event_users(user_id, event_id) VALUE(:user_id, :event_id)";
      $sth = $this->dbh->prepare($sql);
      // ユーザーID（イベント応募者）
      $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
      // イベントID
      $sth->bindParam(':event_id', $arr['event_id'], PDO::PARAM_INT);
      $result = $sth->execute();
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // ログインユーザーが応募したイベントの情報を取得
  public function findById($arr = ['user_id' => "", 'event_id' => ""]) {
    try {
      $sql = "SELECT * FROM event_users WHERE user_id = :user_id AND event_id = :event_id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
      $sth->bindParam(':event_id', $arr['event_id'], PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // 応募キャンセル時にユーザーIDとイベントIDが紐付いた情報を削除
  public function deleteById($id) {
    try {
      $sql = "DELETE FROM event_users WHERE `id` = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(":id", $id, PDO::PARAM_INT);
      $sth->execute();
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // イベント応募者の数を取得
  public function countByEvent($id) {
    try {
      $sql = "SELECT count(*) FROM event_users WHERE event_id = :event_id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(":event_id", $id, PDO::PARAM_INT);
      $sth->execute();
      $count = $sth->fetchColumn();
      return $count;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }
}
?>