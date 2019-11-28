'use strict';
$(function() {
  // 表示したメッセージの消去
  $('.msg').fadeOut(3000);

  // ファイルが選択されたらアップロードの実行
  $('#my_file').on('change', function() {
    $('#upload_form').submit();
  });

  // 削除ボタンクリック時の設定
  $('#delete').on('click', function() {
    if($('.box').length) {
      // 確認用のダイアログの表示
      if (confirm('本当に削除してもよろしいですか?')) {
        // 設定されていれば処理実行
        $('#delete_form').submit();
      }
    } else {
      alert('削除する画像がありません');
    }
  });

  // 画像選択時の設定
  $('.box').on('click', function() {
    // 選択済みクラスの付け替え
    $('.box').removeClass('selected');
    $(this).addClass('selected');
    $("input[value=" + $(this).data('id') + "]").prop('checked', true);

    // 選択した画像の値の取得
    $('#answer').val($(this).data('id'));
  });

  // ボタンクリック時の設定
  $('#poll').on('click', function() {
    // 画像の値が設定されているか判定
    if ($('#answer').val() === '') {
      // 設定されていなければアラート表示
      alert('投票する画像を選択してください');
    } else {
      // 設定されていれば処理実行
      $('#poll_form').submit();
    }
  });

  // エラー表示の設定
  $('.error').fadeOut(3000);
});
