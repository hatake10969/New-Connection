<?php
session_start();
require_once(ROOT_PATH.'Controllers/UserController.php');
$user = new UserController();
$done_users = $user->acquisition();
$error = "";
if ($_POST) {
  foreach($done_users['users'] as $user) {
    if ($user ["email"] == $_POST['email']) {
      $user = new UserController();
      $user->reset_password();
      header("Location:login.php");
      exit();
    }
  }
  $error = "※もう一度正しく入力してください";
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
        <h1><span>パスワード再設定画面</span></h1>
        <form action="" method="post" id="login_form">
          <div id="error_message"><?php if($error != "") {
            echo $error;
          } ?></div>
          <div class="form">
            <div class="content_title"><label for="">メールアドレス</label></div>
            <input type="text" class="input" name="email">
          </div>
          <div class="form">
            <div class="content_title"><label for="">新しいパスワード</label></div>
            <input type="password" class="input" name="password">
          </div>
          <div class="form" id="btn_wrapper">
            <input type="submit" value="登録" id="login_btn">
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