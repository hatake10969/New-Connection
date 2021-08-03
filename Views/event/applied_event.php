<?php
session_start();
require_once(ROOT_PATH.'Controllers/EventController.php');
$event = new EventController();
$result = $event->applied();
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
    <div id=bgimg>
      <div id="contents_wrapper">
        <h1><span>応募したイベント一覧</span></h1>
        <?php if($result): ?>
          <?php foreach($result as $value): ?>
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
        <?php else: ?>
          <div id='no_search'><h1>※ 応募したイベントはありません ※</h1></div>
        <?php endif ?>
      </div>
    </div>
  </main>

  <footer>
    <?php include("../Views/footer.php"); ?>
  </footer>
</body>
</html>