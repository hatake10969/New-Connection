<?php
require_once(ROOT_PATH . '/Models/Event.php');
require_once(ROOT_PATH . '/Models/EventUser.php');
require_once(ROOT_PATH . '/Models/User.php');

class EventController {
  private $request;
  private $Event;
  private $EventUser;
  private $User;

  public function __construct() {
		$this->request['get'] = $_GET;
		$this->request['post'] = $_POST;
    $this->Event = new Event();
    $this->EventUser = new EventUser();
    $this->User = new User();
  }

  // 全てのイベント情報を取得
  public function index() {
    $all_event = $this->Event->findAll();
    return $all_event;
  }

  // イベント検索結果を取得
  public function search() {
    $keyword = $_POST["keyword"];
    $result = $this->Event->findByKeyword($keyword);
    return $result;
  }

  // イベントを応募者の多い順に取得
  public function popular() {
    $popular_event = $this->Event->findByApply();
    return $popular_event;
  }

  // イベントを作成日時の新しい順に取得
  public function new_arrival() {
    $new_event = $this->Event->findByCreate();
    return $new_event;
  }

  // 選択したイベント情報をIDをもとに取得
  public function detail($id) {
    $event_info = $this->Event->findById($id);
    return $event_info;
  }

  // 新しくイベントを作成
  public function create() {
    $name = null;
    $content = null;
    $place = null;
    $date = null;
    $time = null;
    $image = null;
    $id = $_GET["id"];
    if (isset($this->request['post']['name'])) {
      $name = $this->request['post']['name'];
    }
    if (isset($this->request['post']['content'])) {
      $content = $this->request['post']['content'];
    }
    if (isset($this->request['post']['place'])) {
      $place = $this->request['post']['place'];
    }
    if (isset($this->request['post']['date'])) {
      $date = $this->request['post']['date'];
    }
    if (isset($this->request['post']['time'])) {
      $time = $this->request['post']['time'].":00" ;
    }
    if(isset($_FILES['image']['name'])) {
      $image = $_FILES['image']['name'];
      // ユニーク名を作成
      $img = uniqid(mt_rand(), true);
      // ファイル名を変更（ユニーク名＋アップロードされたファイルの拡張子）
      $img .= '.' . substr(strrchr($image, '.'), 1);
      if(move_uploaded_file($_FILES['image']['tmp_name'],"./img/event_img/".$img)){ //一時保存場所から保存したいファイルにコピー
        $image = $img;
      }
    }
    $new_event = [
      'name' => $name,
      'content' => $content,
      'place' => $place,
      'date' => $date,
      'time' => $time,
      'image' => $image,
      'user_id' => $id
    ];
    $result = $this->Event->createById($new_event);
    return $result;
  }

  // 選択したイベント情報をIDをもとに取得
  public function find_event() {
    $id = $_GET["id"];
    $event_info = $this->Event->findById($id);
    return $event_info;
  }

  // イベントの応募者数を取得
  public function apply_count() {
    $id = $_GET["id"];
    $count = $this->EventUser->countByEvent($id);
    return $count;
  }

  // イベント応募者のアイコンを取得
  public function apllied_icon() {
    $id = $_GET["id"];
    $result = $this->User->findIcon($id);
    return $result;
  }

  // イベントの応募状況を取得
  public function apply_info() {
    if ($_SESSION) {
      $user_id = $_SESSION["user"]["id"];
      $event_id = $_GET["id"];
      $apply_info = [
        'user_id' => $user_id,
        'event_id' => $event_id
      ];
      $arr = $this->EventUser->findById($apply_info);
      return $arr;
    }
  }

  // イベント応募
  public function apply() {
    $user_id = $_SESSION["user"]["id"];
    $event_id = $_GET["id"];
    $apply_info = [
      'user_id' => $user_id,
      'event_id' => $event_id
    ];
    $result = $this->EventUser->createById($apply_info);
    return $result;
  }

  // イベント応募をキャンセル
  public function cansel() {
    $user_id = $_SESSION["user"]["id"];
    $event_id = $_GET["id"];
    $applied_info = [
      'user_id' => $user_id,
      'event_id' => $event_id
    ];
    $arr = $this->EventUser->findById($applied_info);
    $this->EventUser->deleteById($arr["id"]);
    return $arr;
  }

  // 作成したイベントを編集
  public function edit() {
    $name = null;
    $content = null;
    $place = null;
    $date = null;
    $time = null;
    $image = null;
    $id = $_GET["id"];
    if (isset($this->request['post']['name'])) {
      $name = $this->request['post']['name'];
    }
    if (isset($this->request['post']['content'])) {
      $content = $this->request['post']['content'];
    }
    if (isset($this->request['post']['place'])) {
      $place = $this->request['post']['place'];
    }
    if (isset($this->request['post']['date'])) {
      $date = $this->request['post']['date'];
    }
    if (isset($this->request['post']['time'])) {
      $time = $this->request['post']['time'];
    }
    if(isset($_FILES['image']['name'])) {
      $image = $_FILES['image']['name'];
      // ユニーク名を作成
      $img = uniqid(mt_rand(), true);
      // ファイル名を変更（ユニーク名＋アップロードされたファイルの拡張子）
      $img .= '.' . substr(strrchr($image, '.'), 1);
      if(move_uploaded_file($_FILES['image']['tmp_name'],"./img/event_img/".$img)){ //一時保存場所から保存したいファイルにコピー
        $image = $img;
      }
    }
    $edit_event = [
      'id' => $id,
      'name' => $name,
      'content' => $content,
      'place' => $place,
      'date' => $date,
      'time' => $time,
      'image' => $image
    ];
    $result = $this->Event->updateById($edit_event);
    return $result;
  }

  // 作成したイベントを削除
  public function delete() {
    $id = $_GET["id"];
    $result = $this->Event->findById($id);
		$this->Event->deleteById($id);
    return $result;
  }

  // 応募したイベントを取得
  public function applied() {
    $id = $_SESSION["user"]["id"];
    $applied_event = $this->Event->findApplied($id);
    return $applied_event;
  }

  // 作成したイベントを取得
  public function planned() {
    $id = $_SESSION["user"]["id"];
    $applied_event = $this->Event->findPlanned($id);
    return $applied_event;
  }
}
?>