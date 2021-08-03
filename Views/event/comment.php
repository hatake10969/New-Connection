<?php
session_start();
require_once(ROOT_PATH.'Controllers/CommentController.php');
require_once(ROOT_PATH.'Controllers/EventController.php');
$comment = new CommentController();
$user_info = $comment->create();
$event = new EventController();
$id = $_POST["id"];
$event_info = $event->detail($id);

$icon = $user_info["icon"];
$nickname = $user_info["nickname"];
$comment = $_POST["comment"];
// $user_info = $event_info["user_id"];
$same = "";
if ($_SESSION) {
  if ($event_info["user_id"] == $_SESSION["user"]["id"]) {
    $same = "（開催者）";
  }
}

$result =
"<div id='comment'>
  <div class='comment_user'>
    <img src='/img/user_img/$icon' alt='' title='' class='user_image'>
    <div>
      <p class='name_info'>
        <span class='user_name'>$nickname</span>
        <span class='organizer'>$same</span>
      </p>
      <p class='comment'>$comment</p>
    </div>
  </div>
</div>";

echo $result;
?>