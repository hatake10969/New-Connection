<?php
session_start();
require_once(ROOT_PATH.'Controllers/EventController.php');
$event = new EventController();
$result = $event->search();

foreach ($result as $value) {
  $id = $value["id"];
  $image = $value["image"];
  $name =$value["name"];
  $place = $value["place"];
  $count = $value["count"] + 1;

  $date = explode("-", $value["date"]);
  if(substr($date[1], 0, 1) == "0") {
    $date[1] = mb_substr($date[1], 1);
  }
  if(substr($date[2], 0, 1) == "0") {
    $date[2] = mb_substr($date[2], 1);
  }
  $search_event[] =
  "<div id='event_wrapper'>
    <a href='detail.php?id=$id' class='event_link'>
    <div id='event_image'>
      <img src='/img/event_img/$image' alt='' title='' id='image'>
    </div>
    <div id='event_details'>
      <p class='event_name'><span>$name</span></p>
      <p>開催日時：$date[1]月$date[2]日</p>
      <p>開催場所：$place</p>
      <p>参加人数：現在 $count 人 参加予定</p>
    </div>
  </div>";
  }
  if ($result) {
    foreach ($search_event as $value) {
      echo $value;
    }
  }else {
    $error = "<div id='no_search'><h1>検索したキーワードに該当するイベントはありませんでした</h1></div>";
    echo $error;
  }
?>
