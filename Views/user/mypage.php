<?php
session_start();
require_once(ROOT_PATH.'Controllers/UserController.php');
$user = new UserController();
$params = $user->mypage();
$img = "/img/user_img/".$params["user"]["icon"];

if(!isset($_SESSION['user'])) {
	header('Location:/user/login.php');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New-Connection</title>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" type="text/css" href="/css/mypage.css">
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
        <div><img src="<?php echo $img; ?>" alt="" title="" id="image"></div>
        <h1><span><?php echo $params['user']['nickname']; ?> さんのマイページ</span></h1>
        <div class="mypage_content"><a href="edit_profile.php?id=<?php echo $params['user']['id']; ?>" class="mypage_link">プロフィールを編集する</a></div>
        <div class="mypage_content"><a href="/event/applied_event.php" class="mypage_link">応募したイベント</a></div>
        <div class="mypage_content"><a href="/event/planned_event.php" class="mypage_link">企画したイベント</a></div>
        <div class="mypage_content"><a href="/event/create.php?id=<?php echo $params['user']['id']; ?>" class="mypage_link">イベントを作成する</a></div>
      </div>
    </div>
  </main>

  <footer>
    <?php include("../Views/footer.php"); ?>
  </footer>
</body>
</html>