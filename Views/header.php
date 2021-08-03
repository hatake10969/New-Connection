<?php
if ($_SESSION) {
  if ($_SESSION["user"]) {
    $judgment = "yes";
  }
}else {
  $judgment = "no";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New-Connection</title>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" type="text/css" href="/css/header.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="/js/header.js"></script>
</head>

<body>
  <div id="header_wrapper">
    <!-- <div class="split"></div> -->
    <div id="title" class="split">
      <a href="/event/index.php" id="title_link">
        <h1>New Connection</h1>
      </a>
    </div>
    <div id="choice" class="split">
      <?php if($judgment == "yes"): ?>
        <div id="yes_log">
          <p id="mypage"><a href="/user/mypage.php" class="choice_content">マイページ</a></p>
          <p id="logout"><a href="/user/logout.php" class="choice_content">ログアウト</a></p>
        </div>
      <?php else: ?>
        <div id="not_log">
          <p id="signup"><a href="/user/signup.php" class="choice_content">新規登録</a></p>
          <p id="login"><a href="/user/login.php" class="choice_content">ログイン</a></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>