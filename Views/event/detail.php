<?php
session_start();
require_once(ROOT_PATH.'Controllers/EventController.php');
require_once(ROOT_PATH.'Controllers/CommentController.php');
$event = new EventController();

// 応募状況の確認
$apply_info = $event->apply_info();
if ($apply_info) {
  // 応募済みの場合
  $done = "yes";
}else {
  // 未応募の場合
  $done = "no";
}

// 応募者数の確認
$count = $event->apply_count();

// イベント応募者のアイコンを取得
$icons = $event->apllied_icon();

// イベント情報を取得
$id = $_GET["id"];
$event_info = $event->detail($id);
// 開催年月日を「-」ごとに分割して配列化
$date = explode("-", $event_info["date"]);
// 開催月の先頭が「0」の場合削除する
if (substr($date[1], 0, 1) == "0") {
  $date[1] = mb_substr($date[1], 1);
}
// 開催日の先頭が「0」の場合削除する
if (substr($date[2], 0, 1) == "0") {
  $date[2] = mb_substr($date[2], 1);
}

// 開催時間を「:」ごとに分割して配列化
$time = explode(":", $event_info["time"]);
// 開催時の先頭が「0」の場合削除する
if (substr($time[0], 0, 1) == "0") {
  $time[0] = mb_substr($time[0], 1);
}

// イベント作成者の情報を取得
$id = $event_info["user_id"];
$eventer = $event->findProfile($id);

// コメント情報の取得
$comment = new CommentController();
$comments = $comment->get();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New-Connection</title>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" type="text/css" href="/css/detail.css">
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
        <h1><span><?= $event_info["name"]; ?></span></h1>
        <div id="event_image">
          <img src="/img/event_img/<?= $event_info["image"]; ?>" alt="" title="" id="image">
        </div>
        <div id="event_details">
          <p><span>開催日時</span></p>
          <p class="detail"><?= $date[1]; ?>月<?= $date[2]; ?>日  <?= $time[0]; ?>時<?= $time[1]; ?>分〜</p>
          <p><span>開催場所</span></p>
          <p class="detail"><?= $event_info["place"]; ?></p>
          <p><span>イベント内容</span></p>
          <p class="detail"><?= nl2br($event_info["content"]); ?></p>
          <p><span>参加人数</span></p>
          <p class="detail">現在 <?= $count + 1; ?>人 参加予定</p>
          <p id="icons">
              <img src="/img/user_img/<?= $eventer['icon']?>" alt="" class="icon_img">
            <?php foreach ($icons as $value): ?>
              <img src="/img/user_img/<?= $value['icon']?>" alt="" class="icon_img">
            <?php endforeach ?>
          </p>
        </div>

        <div id="choices">
          <!-- 管理者は全てを選択可能 -->
          <?php if($_SESSION): ?>
            <?php if($_SESSION["user"]["role"] == 0): ?>
              <?php if($done == "no"): ?>
                <div><a href="apply.php?id=<?= $event_info["id"]; ?>" class="choice" id="apply">応募</a></div>
              <?php elseif($done == "yes"): ?>
                <div><a href="cansel.php?id=<?= $event_info["id"]; ?>" class="choice" id="cansel">応募をキャンセル</a></div>
              <?php endif ?>
              <div><a href="edit_event.php?id=<?= $event_info["id"]; ?>" class="choice">編集</a></div>
              <div><a href="delete.php?id=<?= $event_info["id"]; ?>" class="choice" id="delete">削除</a></div>
            <!-- イベント作成者ではないver. -->
            <?php elseif($event_info["user_id"] != $_SESSION["user"]["id"]): ?>
              <?php if($done == "no"): ?>
                <div><a href="apply.php?id=<?= $event_info["id"]; ?>" class="choice" id="apply">応募</a></div>
              <?php elseif($done == "yes"): ?>
                <div><a href="cansel.php?id=<?= $event_info["id"]; ?>" class="choice" id="cansel">応募をキャンセル</a></div>
              <?php endif ?>
            <!-- イベント作成者ver. -->
            <?php else: ?>
              <div><a href="edit_event.php?id=<?= $event_info["id"]; ?>" class="choice">編集</a></div>
              <div><a href="delete.php?id=<?= $event_info["id"]; ?>" class="choice" id="delete">削除</a></div>
            <?php endif ?>
          <?php else: ?>
            <p id="attention">※応募・編集・削除を行うにはログインが必要です※</p>
          <?php endif ?>
        </div>

        <div id="comment_wrapper">
          <div id="comments">
            <?php foreach($comments as $value): ?>
              <div id="comment">
                <div class="comment_user">
                  <img src="/img/user_img/<?= $value['icon']?>" alt="" title="" class="user_image">
                  <div>
                    <p class="name_info">
                      <span class="user_name"><?= $value['nickname']?></span>
                      <?php if($_SESSION): ?>
                        <?php if($event_info['user_id'] == $value['id']): ?>
                          <span class="organizer">（開催者）</span>
                        <?php endif ?>
                      <?php endif ?>
                    </p>
                    <p class="comment"><?= $value['message']?></p>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>

          <?php if($_SESSION): ?>
            <input type="text" placeholder="コメントを入力" id="comment_input">
            <input type="submit" value="送信" id="comment_btn">
          <?php else: ?>
            <p id="attention">※コメントをするにはログインが必要です※</p>
          <?php endif; ?>
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