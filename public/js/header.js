$(function() {


  // ログアウト確認ポップアップ
  function logout_speach() {
    let u = new SpeechSynthesisUtterance();
    u.text = "ログアウトしてよろしいですか？";
    u.lang = 'ja-JP';
    u.rate = 1.3;
    speechSynthesis.speak(u);
  }

  $("#logout").on("click", function(e) {
    logout_speach();
    if (confirm("ログアウトしてよろしいですか？")) {
      alert("ログアウトしました");
    }else {
      alert("ログアウトをキャンセルしました");
      e.preventDefault();
    }
  });

});