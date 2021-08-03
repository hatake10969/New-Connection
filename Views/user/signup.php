<?php
session_start();
require_once(ROOT_PATH.'Controllers/UserController.php');
$user = new UserController();
$done_users = $user->acquisition();
$errors = [];
if (isset($_POST)) {
  // ニックネームのバリデーション
  if (isset($_POST["nickname"])) {
    if (empty($_POST["nickname"])) {
      $errors["nickname"] = "ニックネームを入力してください";
    }
  }
  // メールアドレスのバリデーション
  if (isset($_POST["email"])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (empty($_POST["email"])) {
      $errors['email'] = "メールアドレスを入力してください";
    }elseif ($email == false) {
      $errors['email'] = "正しいメールアドレスを入力してください";
    }
    foreach($done_users['users'] as $user) {
      if ($user['email'] == $_POST['email']) {
        $errors['email'] = "既に登録されているメールアドレスです";
      }
    }
  }
  // パスワードのバリデーション
  if (isset($_POST["password"])) {
    if (empty($_POST["password"])) {
      $errors['password'] = "パスワードを入力してください";
    }
  }
  // アイコンのバリデーション
  if (isset($_FILES["icon"])) {
    if (empty($_FILES["icon"]['name'])) {
      $errors["icon"] = "アイコンを設定してください";
    }
  }

  if (count($errors) == 0) {
    $user = new UserController();
    $user->signup();
    $params = $user->login();
    if(!empty($params['user'])) {
      $_SESSION['user'] = $params['user'];
      header('Location:/event/index.php');
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New-Connection</title>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" type="text/css" href="/css/signup.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="/js/index.js"></script>
</head>

<body>
  <header>
    <?php include("../Views/header.php"); ?>
  </header>

  <main>
    <div id=bgimg>
      <div id="contents_wrapper">
        <h1><span>新規登録画面</span></h1>
        <form action="" method="post" id="signup_form" enctype="multipart/form-data">
          <!-- ニックネーム -->
          <div class="form">
            <div class="content_title">
              <label for="">ニックネーム</label>
              <!-- ニックネームのバリデーション -->
              <span class="validation_message"><?php
                if (isset($_POST['nickname'])) {
                  if (empty($_POST['nickname'])) {
                    echo $errors['nickname'];
                  }
                }
              ?></span>
            </div>
            <input type="text" name="nickname" class="input">
          </div>

          <!-- メールアドレス -->
          <div class="form">
            <div class="content_title">
              <label for="">メールアドレス</label>
              <!-- メールアドレスのバリデーション -->
              <span class="validation_message"><?php
                if (isset($_POST['email'])) {
                  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    echo $errors['email'];
                  }else {
                    foreach ($done_users['users'] as $user) {
                      if ($user['email'] == $_POST['email']) {
                        echo $errors['email'];
                      }
                    }
                  }
                }
              ?></span>
            </div>
            <input type="text" name="email" class="input">
          </div>

          <!-- パスワード -->
          <div class="form">
            <div class="content_title">
              <label for="">パスワード</label>
              <!-- パスワードのバリデーション -->
              <span class="validation_message"><?php
                if (isset($_POST['password'])) {
                  if (empty($_POST['password'])) {
                    echo $errors['password'];
                  }
                }
              ?></span>
            </div>
            <input type="password" name="password" class="input">
          </div>

          <!-- アイコン -->
          <div class="form">
            <div class="content_title">
              <label for="">アイコン</label>
              <!-- アイコンのバリデーション -->
              <span class="validation_message"><?php
                if (isset($_FILES['icon'])) {
                  if (empty($_FILES['icon']['name'])) {
                        echo $errors['icon'];
                    }
                }
              ?></span>
            </div>
            <input type="file" name="icon" class="input">
          </div>

          <div class="form" id="btn_wrapper">
            <input type="submit" value="新規登録" id="signup_btn">
          </div>
        </form>
      </div>
    </div>
  </main>

  <footer>
    <?php include("../Views/footer.php"); ?>
  </footer>
</body>
</html>