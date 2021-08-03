<?php
session_start();
require_once(ROOT_PATH.'Controllers/UserController.php');
$user = new UserController();
$params = $user->login();
$error = "";
if (isset($params["user"])) {
  $_SESSION["user"] = $params["user"];
  header("Location:/event/index.php");
  exit();
}else {
  if ($_POST) {
    if (empty($params["user"])) {
      $error = "※もう一度正しく入力してください";
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
  <link rel="stylesheet" type="text/css" href="/css/login.css">
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
        <h1><span>ログイン画面</span></h1>
        <form action="" method="post" id="login_form">
          <div id="error_message"><?php if($error != "") {
            echo $error;
          } ?></div>
          <div class="form">
            <div class="content_title"><label for="">メールアドレス</label></div>
            <input type="text" name="email" class="input">
          </div>
          <div class="form">
            <div class="content_title"><label for="">パスワード</label></div>
            <input type="password" name="password" class="input">
          </div>
          <div class="form" id="btn_wrapper">
            <input type="submit" value="ログイン" id="login_btn">
          </div>
          <!-- <div class="form" id="btn_wrapper">
            <input type="submit" value="パスワードを忘れた方はこちら" id="forget_btn">
          </div> -->
        </form>
        <div class="form" id="btn_wrapper">
          <a href="reset_password.php" id="forget_btn">パスワードを忘れた方はこちら</a>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <?php include("../Views/footer.php"); ?>
  </footer>
</body>
</html>