<?php
session_start();
require_once(ROOT_PATH.'Controllers/EventController.php');
$event = new EventController();
$result = $event->apply();
if ($result == 1) {
  $url = "detail.php?id=".$_GET["id"];
  header("Location: $url");
}
?>