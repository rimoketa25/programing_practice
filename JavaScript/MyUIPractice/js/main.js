'use strict';

{
  //// ハンバーガーメニュー ////
  // 要素の取得
  const show1 = document.getElementById('show1');
  const show2 = document.getElementById('show2');
  const hide = document.getElementById('hide');
  const main = document.getElementById('main');

  // メニューの表示
  show1.addEventListener('click', () => {
    document.body.classList.add('menu-open');
  });

  hide.addEventListener('click', () => {
    document.body.classList.remove('menu-open');
  });

  show2.addEventListener('click', () => {
    if (main.classList.contains('menu-open')) {
      main.classList.remove('menu-open');
    } else {
      main.classList.add('menu-open');
    }
  });


  //// タブメニュー ////
  // 要素の取得
  const menuItems = document.querySelectorAll('.tab li a');
  const contents = document.querySelectorAll('.content');

  // タブメニューの切り替え
  menuItems.forEach(clickedItem => { // 全a要素の取得
    clickedItem.addEventListener('click', e => { // クリックされた要素に対してイベントの設定
      e.preventDefault(); // デフォルトの挙動の制限

      // 全a要素からactiveクラスの消去
      menuItems.forEach(item => {
        item.classList.remove('active');
      });

      // クリックされたa要素にactiveクラスの追加
      clickedItem.classList.add('active');

      // 全contentからactiveクラスの消去
      contents.forEach(content => {
        content.classList.remove('active');
      });

      // クリックされたa要素に対応するcontentにactiveクラスの追加
      document.getElementById(clickedItem.dataset.id).classList.add('active');
    });
  });


  //// モーダルウィンドウ ////
  // 要素の取得
  const open = document.getElementById('open');
  const close = document.getElementById('close');
  const modal = document.getElementById('modal');
  const mask = document.getElementById('mask');

  // モーダルウィンドウの表示
  open.addEventListener('click', () => {
    modal.classList.remove('hidden');
    mask.classList.remove('hidden');
  });

  // ×ボタンを押してモーダルウィンドウを閉じる
  close.addEventListener('click', () => {
    modal.classList.add('hidden');
    mask.classList.add('hidden');
  });

  // モーダルウィンドウ外のクリックでモーダルウィンドウを閉じる
  mask.addEventListener('click', () => {
    close.click();
  });
}
