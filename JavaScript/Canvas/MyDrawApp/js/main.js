'use strict';

$(() => {
  // 変数宣言
  let startX,
    startY,
    x,
    y,
    borderWidth = $('#mycanvas').css('border-width').replace('px', ''), // Canvasに設定したborderの幅
    isDrawing = false; // 描画するかどうかの判定

  // 画像作成関数
  function createImage() {
    // 画像の作成
    const img = $('<img>').attr({
      width: 100,
      height: 50,
      src: canvas.toDataURL()
    });

    // ダウンロード用のリンク作成
    const link = $('<a>').attr({
      href: canvas.toDataURL().replace('image/png', 'application/octet-stream'),
      download: new Date().getTime() + '.png'
    });

    // サムネイル画像として追加
    $('#gallery').append(link.append(img.addClass('thumbnail')));
  }

  // 各ボタンの動作設定関数
  function setup(ctx) {
    // 描画色の設定
    $('#penColor').change(function () {
      ctx.strokeStyle = $(this).val();
    });

    // 描画幅の設定
    $('#penWidth').change(function () {
      ctx.lineWidth = $(this).val();
    });

    // 描画領域のリセット
    $('#erase').click(function () {
      // 確認
      if (!confirm('本当に消去しますか？')) return;

      // リセット
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    // 画像への変換
    $('#save').click(function () {
      // 画像の作成
      createImage();

      // リセット
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    });
  }

  // 描画関数
  function draw() {
    // 描画処理
    $('#mycanvas').mousedown(function (e) {
      // 始点の取得
      isDrawing = true;
      startX = e.pageX - $(this).offset().left - borderWidth;
      startY = e.pageY - $(this).offset().top - borderWidth;
    })
      .mousemove(function (e) {
        // マウス押下時以外は処理しない
        if (!isDrawing) return;

        // 終点の取得
        x = e.pageX - $(this).offset().left - borderWidth;
        y = e.pageY - $(this).offset().top - borderWidth;

        // 描画処理
        ctx.beginPath();
        ctx.moveTo(startX, startY);
        ctx.lineTo(x, y);
        ctx.stroke();

        // 始点の変更
        startX = x;
        startY = y;
      })
      .mouseup(function () {
        isDrawing = false;
      })
      .mouseleave(function () {
        isDrawing = false;
      });
  }

  // Canvasの設定
  const canvas = document.getElementById('mycanvas');
  if (typeof canvas.getContext === 'undefined') return;
  const ctx = canvas.getContext('2d');

  // 各ボタンの動作の設定
  setup(ctx);

  // 描画処理
  draw();
});