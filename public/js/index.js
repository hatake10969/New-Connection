$(function() {
  // 検索時のAjax処理
  $("#search_form").on("submit", function(e) {
    e.preventDefault();
    let keyword = $("#keyword").val();
    $("#keyword").val("");
    $.ajax({
      url:'./search.php', //送信先
      type:'POST', //送信方法
      datatype: 'json', //受け取りデータの種類
      data:{
        'keyword': keyword
      }
    // レスポンス結果が成功の場合
    }).done(function (data) {
      $("#search_result").empty(); //要素内を削除
      $("#search_result").css("display", "block");
      $("#normal").css("display", "none");
      $("#popular").css("display", "none");
      $("#new_arrival").css("display", "none");
      $('#search_result').append(data); //id要素searchの最後にdataを追加
      // レスポンス結果がエラーの場合
    }).fail( function(data) {
      console.log(data);
      $('#contents_wrapper').append("エラーが発生しました。もう一度入力してください");
    })
  })

  // 人気順クリック時の処理
  $("#left").on("click", function(e) {
    e.preventDefault();
    // 表示の変更
    $("#search_result").css("display", "none");
    $("#normal").css("display", "none");
    $("#popular").css("display", "block");
    $("#new_arrival").css("display", "none");
  })

  // // 新着順クリック時の処理
  $("#right").on("click", function(e) {
    e.preventDefault();
    // 表示の変更
    $("#search_result").css("display", "none");
    $("#normal").css("display", "none");
    $("#popular").css("display", "none");
    $("#new_arrival").css("display", "block");
  })

  // 応募完了ポップアップ
  $("#apply").on("click", function() {
    alert("応募が完了しました！");
  });

  // 応募キャンセル完了ポップアップ
  $("#cansel").on("click", function() {
    alert("応募をキャンセルしました");
  });

  // 削除確認ポップアップ
  function delete_speach() {
    let u = new SpeechSynthesisUtterance();
    u.text = "本当に削除してよろしいですか？";
    u.lang = 'ja-JP';
    u.rate = 1.3;
    speechSynthesis.speak(u);
  }

  $("#delete").on("click", function(e) {
    delete_speach();
    if (confirm("本当に削除してよろしいですか？")) {
      alert("削除が完了しました");
    }else {
      alert("削除をキャンセルしました");
      e.preventDefault();
      }
  });

  // コメント送信時のAjax処理
  $("#comment_btn").on("click", function() {
    let url = location.search;
    let id = url.substr(4);
    let comment_value = $("#comment_input").val();
    $.ajax({
      url:'./comment.php', //送信先
      type:'POST', //送信方法
      datatype: 'json', //受け取りデータの種類
      data:{
        'comment': comment_value,
        'id': id
      }
    // レスポンス結果が成功の場合
    }).done(function (data) {
      $('#comments').append(data); //id要素commentsの最後にdataを追加
      $("#comment_input").val("");
    // レスポンス結果がエラーの場合
    }).fail( function(data) {
      $('#comments').append("エラーが発生しました。もう一度入力してください");
    })
  })
});