<?php
require_once(ROOT_PATH . '/Models/User.php');

class UserController {
  private $request;
  private $User;

  public function __construct() {
		$this->request['get'] = $_GET;
		$this->request['post'] = $_POST;
    $this->User = new User();
  }

  public function signup() {
    $nickname = null;
    $email    = null;
    $password = null;
    $icon     = null;

    if (isset($this->request['post']['nickname'])) {
      $nickname = $this->request['post']['nickname'];
    }
    if (isset($this->request['post']['email'])) {
      $email = $this->request['post']['email'];
    }
    if (isset($this->request['post']['password'])) {
      $password= $this->request['post']['password'];
    }
    if (isset($_FILES['icon']['name'])) {
      $icon = $_FILES['icon']['name'];
      // ユニーク名を作成
      $image = uniqid(mt_rand(), true);
      // ファイル名を変更（ユニーク名＋アップロードされたファイルの拡張子）
      $image .= '.' . substr(strrchr($icon, '.'), 1);
      if(move_uploaded_file($_FILES['icon']['tmp_name'],"./img/user_img/".$image)){ //一時保存場所から保存したいファイルにコピー
        $icon = $image;
      }
    }
    $new_user = [
      'nickname' => $nickname,
      'email' => $email,
      'password' => $password,
      'icon' => $icon
    ];
    echo $this->User->signup($new_user);
  }

  public function login() {
    $email    = null;
    $password = null;
    if(isset($this->request['post']['email'])) {
      $email = $this->request['post']['email'];
    }
    if(isset($this->request['post']['password'])) {
      $password = $this->request['post']['password'];
    }
    $registered = [
      'email' => $email,
      'password' => $password
    ];
    $user = $this->User->findUser($registered);
    $params = [
      'user' => $user
    ];
    return $params;
  }

  public function reset_password() {
    $email    = null;
    $password = null;
    if(isset($this->request['post']['email'])) {
      $email = $this->request['post']['email'];
    }
    if(isset($this->request['post']['password'])) {
      $password = $this->request['post']['password'];
    }
    $registered = [
      'email' => $email,
      'password' => $password
    ];
    $this->User->updateByPassword($registered);
  }

  public function mypage() {
    $email    = null;
    $password = null;
    if (isset($_SESSION['user']['email'])) {
      $email = $_SESSION['user']['email'];
    }
    if (isset($_SESSION['user']['password'])) {
      $password = $_SESSION['user']['password'];
    }
    $registered = [
      'email' => $email,
      'password' => $password
    ];
    $user = $this->User->CheckMyUser($registered);
    $params = [
      'user' => $user
    ];
    return $params;
  }

  public function login_info() {
    $id = $_GET["id"];
    // ログインしているユーザーの全情報を取得
    $user_info = $this->User->findProfile($id);
    return $user_info;
  }

  public function edit_profile() {
    $id = $_GET["id"];
    // ログインしているユーザーの全情報を取得
    $user_info = $this->User->findProfile($id);

    // ここからプロフィール変更の記述
    $nickname = null;
    $icon = null;
    if(isset($this->request['post']['nickname'])) {
      $nickname = $this->request['post']['nickname'];
    }
    if(isset($_FILES['icon']['name'])) {
      $icon = $_FILES['icon']['name'];
      // ユニーク名を作成
      $image = uniqid(mt_rand(), true);
      // ファイル名を変更（ユニーク名＋アップロードされたファイルの拡張子）
      $image .= '.' . substr(strrchr($icon, '.'), 1);
      if(move_uploaded_file($_FILES['icon']['tmp_name'],"./img/user_img/".$image)){ //一時保存場所から保存したいファイルにコピー
        $icon = $image;
      }
    }else {
      $icon = $user_info['icon'];
    }
    $registered = [
      'id' => $id,
      'nickname' => $nickname,
      'icon' => $icon
    ];
    // ニックネームとアイコンの変更を実施
    $this->User->updateByProfile($registered);
    // ログインしているユーザーの全情報を返す
    return $user_info;
  }

  // 登録済みのユーザー情報を取得
  public function acquisition() {
    $done_users = $this->User->findAll();
    $params = [
      'users' => $done_users
    ];
    return $params;
  }




}
?>