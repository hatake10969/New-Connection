<?php
session_start();
require_once(ROOT_PATH.'Controllers/EventController.php');
$errors = [];
if (isset($_POST)) {
  // イベント名のバリデーション
  if (isset($_POST["name"])) {
    if (empty($_POST["name"])) {
      $errors["name"] = "イベント名を入力してください";
    }
  }
  // イベント内容のバリデーション
  if (isset($_POST["content"])) {
    if (empty($_POST["content"])) {
      $errors["content"] = "イベント内容を入力してください";
    }
  }
  // 場所のバリデーション
  if (isset($_POST["place"])) {
    if (empty($_POST["place"])) {
      $errors["place"] = "場所を入力してください";
    }
  }
    // 年月日のバリデーション
  if (isset($_POST["date"])) {
    if (empty($_POST["date"])) {
      $errors["date"] = "年月日を入力してください";
    }
  }
    // 時間のバリデーション
  if (isset($_POST["time"])) {
    if (empty($_POST["time"])) {
      $errors["time"] = "時間を入力してください";
    }
  }
    // イベントイメージのバリデーション
  if (isset($_FILES["image"])) {
    if (empty($_FILES["image"]["name"])) {
      $errors["image"] = "イベントイメージを設定してください";
    }
  }
  if (count($errors) == 0) {
    $event = new EventController();
    $result = $event->create();
    if ($result == 1) {
      header('Location:/event/index.php');
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
  <link rel="stylesheet" type="text/css" href="/css/create.css">
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
        <h1><span>イベント作成画面</span></h1>
        <form action="" method="post" id="create_form" enctype="multipart/form-data">
          <div class="content_title">
            <label for="">イベント名</label>
            <span class="validation_message"><?php
              if (isset($_POST['name'])) {
                if (empty($_POST['name'])) {
                  echo $errors['name'];
                }
              }
            ?></span>
          </div>
          <input type="text" class="content content_border" name="name">

          <div class="content_title">
            <label for="">イベント内容</label>
            <span class="validation_message"><?php
              if (isset($_POST['content'])) {
                if (empty($_POST['content'])) {
                  echo $errors['content'];
                }
              }
            ?></span>
          </div>
          <textarea name="content" id="" rows="10" class="content content_border"></textarea>

          <div class="content_title">
            <label for="">場所</label>
            <span class="validation_message"><?php
              if (isset($_POST['place'])) {
                if (empty($_POST['place'])) {
                  echo $errors['place'];
                }
              }
            ?></span>
          </div>
          <input type="text" class="content content_border" name="place">

          <div class="content_title">
            <label for="">年月日</label>
            <span class="validation_message"><?php
              if (isset($_POST['date'])) {
                if (empty($_POST['date'])) {
                  echo $errors['date'];
                }
              }
            ?></span>
          </div>
          <input type="date" class="content_border" id="date" name="date">

          <div class="content_title">
            <label for="">時間</label>
            <span class="validation_message"><?php
              if (isset($_POST['time'])) {
                if (empty($_POST['time'])) {
                  echo $errors['time'];
                }
              }
            ?></span>
          </div>
          <input type="time" class="content_border" name="time">

          <div class="content_title">
            <label for="">イベントイメージ</label>
            <span class="validation_message"><?php
              if (isset($_FILES['image'])) {
                if (empty($_FILES['image']['name'])) {
                  echo $errors['image'];
                }
              }
            ?></span>
          </div>
          <input type="file" name="image">

          <div id="btn_wrapper"><input type="submit" value="作成" id="create_btn"></div>
        </form>
      </div>
    </div>
  </main>

  <footer>
    <?php include("../Views/footer.php"); ?>
  </footer>
</body>
</html>