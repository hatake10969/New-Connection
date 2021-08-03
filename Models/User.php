<?php
require_once(ROOT_PATH . '/Models/Db.php');

class User extends Db {
  private $table = 'users';
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // ユーザー新規登録
  public function signup($arr = ['nickname' => "", 'email' => "", 'password' => "", 'icon' => ""]) {
    try {
      $sql = "INSERT INTO users(nickname, email, password, icon, role) VALUE(:nickname, :email, :password, :icon, :role)";
      $sth = $this->dbh->prepare($sql);
      // ニックネーム
      $sth->bindParam(':nickname', $arr['nickname'], PDO::PARAM_STR);
      // メールアドレス
      $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
      // パスワード
      $hash = password_hash($arr['password'], PASSWORD_DEFAULT);
      $sth->bindParam(':password', $hash, PDO::PARAM_STR);
      // アイコン
      // if(move_uploaded_file($_FILES['icon']['tmp_name'],"./img/".$arr['icon'])){ //一時保存場所から保存したいファイルにコピー
        $sth->bindParam(':icon', $arr['icon'], PDO::PARAM_STR);
      // }
      // ロールカラム
      $sth->bindValue(':role', 1, PDO::PARAM_INT);
      $sth->execute();
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // ログインするユーザーが存在するか確認
  public function findUser($arr = ['email' => "", 'password' => ""]) {
    try {
      $sql = "SELECT * FROM users WHERE email = :email";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      if (isset($result['password'])) {
        if (password_verify($arr['password'], $result['password'])) {
          return $result;
        }
      }
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  public function CheckMyUser($arr = ['email' => "", 'password' => ""]) {
    try {
      $sql = "SELECT * FROM users WHERE email = :email";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      if (isset($result['password'])) {
        if ($arr['password'] == $result['password']) {
          return $result;
        }
      }
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // 登録されているユーザー情報を全て取得
  public function findAll() {
    try {
      $sql = 'SELECT * FROM users';
      $sth = $this->dbh->query($sql);
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // パスワードを変更
  public function updateByPassword($arr = ['email' => "", 'password' => ""]) {
    try {
      $sql = "UPDATE users SET `password` = :password WHERE `email` = :email";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(":email", $arr['email'], PDO::PARAM_STR);
      $hash = password_hash($arr['password'], PASSWORD_DEFAULT);
      $sth->bindParam(':password', $hash, PDO::PARAM_STR);
      $sth->execute();
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

    // idからユーザー情報を全て取得
    public function findProfile($id) {
      try {
        $sql = "SELECT * FROM users WHERE id = :id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
      } catch (PDOException $e) {
        echo 'データベースにアクセスできません！'.$e->getMessage();
      }
    }

  // プロフィールを変更
  public function updateByProfile($arr = ['id' => "", 'nickname' => "", 'icon' => ""]) {
    try {
      $sql = "UPDATE users SET `nickname` = :nickname, `icon` = :icon WHERE `id` = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(":nickname", $arr['nickname'], PDO::PARAM_STR);
      $sth->bindParam(":icon", $arr['icon'], PDO::PARAM_STR);
      $sth->bindParam(':id', $arr['id'], PDO::PARAM_INT);
      $sth->execute();
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }

  // イベント参加予定者のアイコンを取得
  public function findIcon($id) {
    try {
      $sql = "SELECT users.icon FROM users LEFT JOIN event_users ON users.id = event_users.user_id
      WHERE event_users.event_id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(":id", $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません！'.$e->getMessage();
    }
  }



}
?>