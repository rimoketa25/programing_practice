'use strict';

$(function() {
  // 選択肢クリック時の設定
  $('.answer').on('click', function() {
    // 要素の取得
    const $selected = $(this);

    // 既にクリックされていたら処理を実行しない
    if ($selected.hasClass('correct') || $selected.hasClass('wrong')) {
      return;
    }

    // 選択済みのクラスの付与
    $selected.addClass('selected');

    // 解答の取得
    const answer = $selected.text();

    // ajaxで正誤判定
    $.post('/_answer.php', {
      answer: answer,
      token: $('#token').val()
    }).done(function(res) {
      // 通信終了後
      // 各選択肢に対して正誤クラスの付与
      $('.answer').each(function() {
        if ($(this).text() === res.correct_answer) {
          $(this).addClass('correct');
        } else {
          $(this).addClass('wrong');
        }
      });

      // 結果の表示
      if (answer === res.correct_answer) {
        $selected.text(answer + ' ... CORRECT!');
      } else {
        $selected.text(answer + ' ... WRONG!');
      }

      // ボタンの活性化
      $('#btn').removeClass('disabled');
    });
  });

  // ボタンクリック時の設定
  $('#btn').on('click', function() {
    if (!$(this).hasClass('disabled')) {
      // 再読み込み
      location.reload();
    }
  });
});
