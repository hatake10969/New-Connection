<?php
  require_once(ROOT_PATH .'Controllers/UserController.php');
  session_start();
  //セッションを削除
  $_SESSION['user'] = [];
  session_destroy();
  header('Location:/event/index.php');
?>