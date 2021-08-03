<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Event extends Db {
  private $table = 'events';
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  public function findAll() {
    try {
      $sql = "SELECT events.*, count(event_users.event_id) AS count
              FROM events LEFT JOIN event_users ON events.id = event_users.event_id
              GROUP BY events.id";
      $sth = $this->dbh->query($sql);
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  public function findByKeyword($keyword) {
    try {
      $sql = "SELECT events.*, count(event_users.event_id) AS count
              FROM events
              LEFT JOIN event_users ON events.id = event_users.event_id
              WHERE events.name LIKE '%$keyword%' OR events.content LIKE '%$keyword%' OR events.place LIKE '%$keyword%'
              GROUP BY events.id";
      $sth = $this->dbh->query($sql);
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // イベント応募者の多い順に取得
  public function findByApply() {
    try {
      $sql = "SELECT events.*, count(event_users.event_id) AS count
              FROM events LEFT JOIN event_users ON events.id = event_users.event_id
              GROUP BY events.id ORDER BY count(event_users.event_id) DESC";
      $sth = $this->dbh->query($sql);
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // イベント作成日時の新しい順に取得
  public function findByCreate() {
    try {
      $sql = "SELECT events.*, count(event_users.event_id) AS count
              FROM events LEFT JOIN event_users ON events.id = event_users.event_id
              GROUP BY events.id ORDER BY events.created_at DESC";
      $sth = $this->dbh->query($sql);
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  public function findById($id) {
    try {
      $sql = "SELECT * FROM events WHERE id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // 応募したイベント一覧を取得
  public function findApplied($id) {
    try {
      $sql = "SELECT events.*, count(event_users.event_id) AS count
              FROM events LEFT JOIN event_users ON events.id = event_users.event_id
              WHERE event_users.user_id = :id GROUP BY events.id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // 作成したイベント一覧を取得
  public function findPlanned($id) {
    try {
      $sql = "SELECT events.*, count(event_users.event_id) AS count
              FROM events LEFT JOIN event_users ON events.id = event_users.event_id
              WHERE events.user_id = :id GROUP BY events.id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  public function createById($arr = ['name' => "", 'content' => "", 'place' => "", 'date' => "", 'time' => "", 'image' => "", 'user_id' => ""]) {
    try {
      $sql = "INSERT INTO events(name, content, place, date, time, image, user_id) VALUE(:name, :content, :place, :date, :time, :image, :user_id)";
      $sth = $this->dbh->prepare($sql);
      // イベント名
      $sth->bindParam(':name', $arr['name'], PDO::PARAM_STR);
      // イベント内容
      $sth->bindParam(':content', $arr['content'], PDO::PARAM_STR);
      // 場所
      $sth->bindParam(':place', $arr['place'], PDO::PARAM_STR);
      // 年月日
      $sth->bindParam(':date', $arr['date'], PDO::PARAM_STR);
      // 時間
      $sth->bindParam(':time', $arr['time'], PDO::PARAM_STR);
      // イベントイメージ
      $sth->bindParam(':image', $arr['image'], PDO::PARAM_STR);
      // ユーザーID（イベント作成者）
      $sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_INT);
      $result = $sth->execute();
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  public function updateById($arr = ['id' => "", 'name' => "", 'content' => "", 'place' => "", 'date' => "", 'time' => "", 'image' => ""]) {
    try {
      $sql = "UPDATE `events` SET `name` = :name, `content` = :content, `place` = :place, `date` = :date, `time` = :time, `image` = :image WHERE `id` = :id";
      $sth = $this->dbh->prepare($sql);
      // イベント名
      $sth->bindParam(':name', $arr['name'], PDO::PARAM_STR);
      // イベント内容
      $sth->bindParam(':content', $arr['content'], PDO::PARAM_STR);
      // 場所
      $sth->bindParam(':place', $arr['place'], PDO::PARAM_STR);
      // 年月日
      $sth->bindParam(':date', $arr['date'], PDO::PARAM_STR);
      // 時間
      $sth->bindParam(':time', $arr['time'], PDO::PARAM_STR);
      // イベントイメージ
      $sth->bindParam(':image', $arr['image'], PDO::PARAM_STR);
      // イベントID
      $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
      $result = $sth->execute();
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  public function deleteById($id) {
    $sql = "DELETE FROM events WHERE `id` = :id";
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(":id", $id, PDO::PARAM_INT);
    $sth->execute();
  }
}
?>