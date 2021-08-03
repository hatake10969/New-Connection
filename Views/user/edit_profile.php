<?php
session_start();
require_once(ROOT_PATH.'Controllers/UserController.php');
$user = new UserController();
$user_info = $user->login_info();

$error_nickname = false;
$error_icon = false;
$errors = [];
if (isset($_POST)) {
  // ニックネームのバリデーション
  if (isset($_POST["nickname"])) {
    if (empty($_POST["nickname"])) {
      $errors["nickname"] = "ニックネームを入力してください";
    }else {
      $error_nickname = true;
    }
  }
  // アイコンのバリデーション
  if (isset($_FILES["icon"])) {
    if (empty($_FILES["icon"]['name'])) {
      $errors["icon"] = "アイコンを設定してください";
    }else {
      $error_icon = true;
    }
  }
  if (count($errors) == 0) {
    if ($error_nickname && $error_icon) {
      $user = new UserController();
      $user_info = $user->edit_profile();
      header('Location: mypage.php');
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
  <link rel="stylesheet" type="text/css" href="/css/edit_profile.css">
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
        <h1><span>プロフィール編集</span></h1>
        <form action="" method="post" id="mypage_form" enctype="multipart/form-data">
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
            <input type="text" class="input" name="nickname" value="<?php echo $user_info["nickname"]; ?>">
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
            <input type="file" class="input" name="icon">
            <div id="btn_wrapper"><input type="submit" value="更新" id="edit_btn"></div>
        </form>
      </div>
    </div>
  </main>

  <footer>
    <?php include("../Views/footer.php"); ?>
  </footer>
</body>
</html>