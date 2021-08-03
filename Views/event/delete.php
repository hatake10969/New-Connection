<?php
session_start();
require_once(ROOT_PATH.'Controllers/EventController.php');
$event = new EventController();
$delete_event = $event->delete();
$delete_event = "./img/event_img/".$delete_event["image"];
unlink($delete_event);
header("Location: index.php");
exit;
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

<!-- <body>
  <header>
    <?php include("../Views/header.php"); ?>
  </header>

  <main>
  </main>

  <footer>
    <?php include("../Views/footer.php"); ?>
  </footer>
</body> -->
</html>