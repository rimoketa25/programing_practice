'use strict';

(() => {
  let angle = 0;

  // 描画関数
  function draw() {
    const r0 = 50; // 内径
    const r1 = 60; // 外径

    // 描画領域の保存
    ctx.save();

    // 座標軸の移動
    ctx.translate(WIDTH / 2, HEIGHT / 2);

    // 描画設定
    ctx.strokeStyle = 'orange';
    ctx.lineWidth = 6;

    // 描画
    ctx.beginPath();
    ctx.moveTo(r0 * Math.cos(Math.PI / 180 * angle), r0 * Math.sin(Math.PI / 180 * angle));
    ctx.lineTo(r1 * Math.cos(Math.PI / 180 * angle), r1 * Math.sin(Math.PI / 180 * angle));
    ctx.stroke();

    // 描画領域の読み込み
    ctx.restore();
  }

  function update() {
    // 半透明で徐々に塗り潰してアニメーション
    ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
    ctx.fillRect(0, 0, WIDTH, HEIGHT);

    // 描画
    draw();

    // ループ処理
    setTimeout(function () {
      angle += 12;
      update();
    }, 60);
  }

  // Canvasの取得
  const stage = document.getElementById('stage');
  if (typeof stage.getContext === 'undefined') {
    return;
  }
  const ctx = stage.getContext('2d');
  const WIDTH = stage.width;
  const HEIGHT = stage.height;

  // 実行
  update();
})();