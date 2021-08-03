<?php
session_start();
require_once(ROOT_PATH.'Controllers/EventController.php');
$event = new EventController();
$result = $event->cansel();
if ($result != "") {
  $url = "detail.php?id=".$_GET["id"];
  header("Location: $url");
}
?>