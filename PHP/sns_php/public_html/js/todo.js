'use strict';

$(function() {
  // 読み込み時にフォームにフォーカスを当てておく
  $('#new_todo').focus();



  // カレンダーの遷移
  $('.link').on('click', function() {
    $('#tValue').attr('value', $(this).attr('name'));
    $('.change_form').submit();
  });

  // 新規Todoの作成
  $('#new_todo_form').on('submit', function() {
    // 入力されたTodoを取得
    const title = $('#new_todo').val();

    // ajax処理
    $.post('_ajax.php', {
      title: title,
      mode: 'create',
      token: $('#token').val()
    }, function(res) {
      // li要素をテンプレートから作成
      const $li = $('#todo_template').clone();

      // 作成した要素に情報の追加
      $li
        .attr('id', 'todo_' + res.id)
        .data('id', res.id)
        .find('.todo_title').text(title);

      // 要素の追加
      $('#todos').prepend($li.fadeIn());

      // フォームにフォーカスを当てる
      $('#new_todo').val('').focus();
    });

    // 画面の遷移を防ぐためにfalseを返却
    return false;
  });

  // Todo完了時
  $('#todos').on('click', '.update_todo', function() {
    // クリックされたTodoのIDを取得
    const id = $(this).parents('li').data('id');

    // ajax処理
    $.post('_ajax.php', {
      id: id,
      mode: 'update',
      token: $('#token').val()
    }, function(res) {
      // 返却値によって、Todoのチェックを付け替える
      if (res.state === '1') {
        $('#todo_' + id).find('.todo_title').addClass('done');
      } else {
        $('#todo_' + id).find('.todo_title').removeClass('done');
      }
    })
  });

  // Todoの削除
  $('#todos').on('click', '.delete_todo', function() {
    // クリックされたTodoのIDを取得
    const id = $(this).parents('li').data('id');

    // 確認用のダイアログの表示
    if (confirm('are you sure?')) {
      // ajax処理
      $.post('_ajax.php', {
        id: id,
        mode: 'delete',
        token: $('#token').val()
      }, function() {
        $('#todo_' + id).fadeOut(800);
      });
    }
  });
});
