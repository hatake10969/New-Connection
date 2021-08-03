<?php
session_start();
require_once(ROOT_PATH.'Controllers/EventController.php');
$event = new EventController();
$all_event = $event->index();
$popular_event = $event->popular();
$new_event = $event->new_arrival();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New-Connection</title>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" type="text/css" href="/css/index.css">
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
    <div id="main_header">
      <div class="bgImg src1"></div>
      <div class="bgImg src2"></div>
      <div class="bgImg src3"></div>
      <div class="bgImg src4"></div>
      <div class="boxString">
        <p id="up">＼イベント多数掲載／</p>
        <p id="down">みんなで一緒に遊びに行こう！</p>
      </div>
    </div>


    <div id=bgimg>
      <div id="contents_wrapper">

        <form action="" method="post" id="search_form">
          <input type="text" placeholder="キーワードを入力" id="keyword" name="keyword">
          <input type="submit" value="検索" id="search">
        </form>

        <div id="order">
          <a href="#" class="order_choice" id="left">人気順</a>
          <a href="#" class="order_choice" id="right">新着順</a>
        </div>

        <!-- 検索結果を表示するブロック要素 -->
        <div id="search_result"></div>

        <div id="normal">
          <?php foreach($all_event as $value): ?>
            <!-- 開催年月日を「-」ごとに分割して配列化 -->
            <?php $date = explode("-", $value["date"]); ?>
            <!-- 開催月の先頭が「0」の場合削除する -->
            <?php if(substr($date[1], 0, 1) == "0"): ?>
              <?php $date[1] = mb_substr($date[1], 1); ?>
            <?php endif ?>
            <!-- 開催日の先頭が「0」の場合削除する -->
            <?php if(substr($date[2], 0, 1) == "0"): ?>
              <?php $date[2] = mb_substr($date[2], 1); ?>
            <?php endif ?>
            <!-- イベント表示はここから -->
            <div id="event_wrapper">
              <a href="detail.php?id=<?= $value["id"]; ?>" class="event_link">
                <div id="event_image">
                  <img src="/img/event_img/<?= $value["image"]; ?>" alt="" title="" id="image">
                </div>
                <div id="event_details">
                  <p class="event_name"><span><?= $value["name"]; ?></span></p>
                  <p>開催日時：<?= $date[1]; ?>月<?= $date[2]; ?>日</p>
                  <p>開催場所：<?= $value["place"]; ?></p>
                  <p>参加人数：現在 <?= $value["count"] + 1; ?>人 参加予定</p>
                </div>
              </a>
            </div>
          <?php endforeach ?>
        </div>

        <!-- 人気順で表示 -->
        <div id="popular">
          <?php foreach($popular_event as $value): ?>
            <!-- 開催年月日を「-」ごとに分割して配列化 -->
            <?php $date = explode("-", $value["date"]); ?>
            <!-- 開催月の先頭が「0」の場合削除する -->
            <?php if(substr($date[1], 0, 1) == "0"): ?>
              <?php $date[1] = mb_substr($date[1], 1); ?>
            <?php endif ?>
            <!-- 開催日の先頭が「0」の場合削除する -->
            <?php if(substr($date[2], 0, 1) == "0"): ?>
              <?php $date[2] = mb_substr($date[2], 1); ?>
            <?php endif ?>
            <!-- イベント表示はここから -->
            <div id="event_wrapper">
              <a href="detail.php?id=<?= $value["id"]; ?>" class="event_link">
                <div id="event_image">
                  <img src="/img/event_img/<?= $value["image"]; ?>" alt="" title="" id="image">
                </div>
                <div id="event_details">
                  <p class="event_name"><span><?= $value["name"]; ?></span></p>
                  <p>開催日時：<?= $date[1]; ?>月<?= $date[2]; ?>日</p>
                  <p>開催場所：<?= $value["place"]; ?></p>
                  <p>参加人数：現在 <?= $value["count"] + 1; ?>人 参加予定</p>
                </div>
              </a>
            </div>
          <?php endforeach ?>
        </div>

        <!-- 新着順で表示 -->
        <div id="new_arrival">
          <?php foreach($new_event as $value): ?>
            <!-- 開催年月日を「-」ごとに分割して配列化 -->
            <?php $date = explode("-", $value["date"]); ?>
            <!-- 開催月の先頭が「0」の場合削除する -->
            <?php if(substr($date[1], 0, 1) == "0"): ?>
              <?php $date[1] = mb_substr($date[1], 1); ?>
            <?php endif ?>
            <!-- 開催日の先頭が「0」の場合削除する -->
            <?php if(substr($date[2], 0, 1) == "0"): ?>
              <?php $date[2] = mb_substr($date[2], 1); ?>
            <?php endif ?>
            <!-- イベント表示はここから -->
            <div id="event_wrapper">
              <a href="detail.php?id=<?= $value["id"]; ?>" class="event_link">
                <div id="event_image">
                  <img src="/img/event_img/<?= $value["image"]; ?>" alt="" title="" id="image">
                </div>
                <div id="event_details">
                  <p class="event_name"><span><?= $value["name"]; ?></span></p>
                  <p>開催日時：<?= $date[1]; ?>月<?= $date[2]; ?>日</p>
                  <p>開催場所：<?= $value["place"]; ?></p>
                  <p>参加人数：現在 <?= $value["count"] + 1; ?>人 参加予定</p>
                </div>
              </a>
            </div>
          <?php endforeach ?>
        </div>

        <?php if($_SESSION): ?>
          <div id="create_wrapper">
            <a href="create.php?id=<?php echo $_SESSION['user']['id']; ?>" id="create_btn"><p id="create_message">イベントを<br>作成する</p></a>
          </div>
        <?php endif ?>

      </div>
    </div>
  </main>

  <footer>
    <?php include("../Views/footer.php"); ?>
  </footer>
</body>
</html>