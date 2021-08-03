<?php
require_once(ROOT_PATH . '/Models/Comment.php');
require_once(ROOT_PATH . '/Models/User.php');

class CommentController {
  private $request;
  private $Comment;
  private $User;

  public function __construct() {
		$this->request['get'] = $_GET;
		$this->request['post'] = $_POST;
    $this->Comment = new Comment();
    $this->User = new User();
  }

  // コメントを投稿
  public function create() {
    // まずDBにコメントを保存する
    $message = $_POST["comment"];
    $user_id = $_SESSION["user"]["id"];
    $event_id = $_POST["id"];
    $new_comment = [
      'message'  => $message,
      'user_id'  => $user_id,
      'event_id' => $event_id
    ];
    $result = $this->Comment->createById($new_comment);
    // 次にユーザーの名前・アイコンを取得する
    $user_info = $this->User->findProfile($_SESSION["user"]["id"]);
    return $user_info;
  }

  // イベントに紐づいたコメント情報を全て取得
  public function get() {
    $id = $_GET["id"];
    $comment_info = $this->Comment->findById($id);
    return $comment_info;
  }
}
?>