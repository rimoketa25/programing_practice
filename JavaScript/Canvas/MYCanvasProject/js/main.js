'use strict';

{
  let t = 0;

  function draw() {
    const canvas = document.getElementById('canvas1');
    const canvas2 = document.getElementById('canvas2');

    // ブラウザがCanvasに対応しているかの確認
    if(typeof canvas.getContext === 'undefined') {
      return;
    }

    // コンテクストの取得
    const ctx = canvas.getContext('2d');
    const ctx2 = canvas2.getContext('2d');

    // 高解像度ディスプレイの対応
    const CANVAS_WIDTH = 600;
    const CANVAS_HEIGHT = 340;
    const dpr = window.devicePixelRatio || 1;
    console.log(dpr);
    canvas.width = CANVAS_WIDTH * dpr;
    canvas.height = CANVAS_HEIGHT * dpr;
    ctx.scale(dpr, dpr);
    canvas.style.width = CANVAS_WIDTH + 'px';
    canvas.style.height = CANVAS_HEIGHT + 'px';

    // 図形の描画
    // 線形グラデーション
    const g1 = ctx2.createLinearGradient(300, 0, canvas2.width, 0);
    g1.addColorStop(0, '#f00');
    g1.addColorStop(0.3, '#0f0');
    g1.addColorStop(1, '#00f');
    ctx2.fillStyle = g1;
    ctx2.fillRect(300, 0, 300, 340);

    // 円形グラデーション
    const g2 = ctx.createRadialGradient(
      canvas2.width / 4, canvas2.height / 4, 5,
      canvas2.width / 4 + 50, canvas2.height / 4 + 50, 200
    );
    g2.addColorStop(0, '#f00');
    g2.addColorStop(0.4, '#0f0');
    g2.addColorStop(1, '#00f');
    ctx2.fillStyle = g2;
    ctx2.fillRect(0, 0, 300, 340);

    // テキストの描画
    ctx.beginPath();
    ctx.moveTo(500, 0);
    ctx.lineTo(500, canvas.height);
    ctx.moveTo(0, 50);
    ctx.lineTo(canvas.width, 50);
    ctx.stroke();
    ctx.font = 'bold 64px Verdana';
    ctx.fillText('Tokyo', 500, 50, 100);
    ctx.textAlign = 'right';
    ctx.textBaseline = 'top';
    ctx.strokeText('Right', 500, 50);

    // 線の描画
    ctx.beginPath();
    ctx.moveTo(150, 150);
    ctx.lineTo(200, 150);
    ctx.lineTo(200, 200);
    ctx.closePath();
    ctx.stroke();

    // 円弧の描画
    ctx.beginPath();
    ctx.arc(150, 100, 25, 0, 2 * Math.PI);
    ctx.stroke();

    ctx.beginPath();
    ctx.arc(200, 100, 25, 0, 300 / 180 * Math.PI);
    ctx.stroke();

    ctx.beginPath();
    ctx.arc(250, 100, 25, 0, 300 / 180 * Math.PI, true);
    ctx.fill();

    ctx.beginPath();
    ctx.moveTo(250, 100);
    ctx.arc(250, 100, 25, 0, 1 / 3 * Math.PI);
    ctx.fill();

    // 楕円の描画
    ctx.beginPath();
    ctx.ellipse(175, 40, 50, 30, 0, 0, 2 * Math.PI);
    ctx.stroke();

    // パスでの四角の描画;
    ctx.beginPath();
    ctx.rect(220, 170, 50, 50);
    ctx.stroke();

    // 線のスタイルの設定
    ctx.beginPath();
    ctx.moveTo(50, 150);
    ctx.lineTo(100, 150);
    ctx.setLineDash([5, 10]);
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(50, 180);
    ctx.lineTo(100, 180);
    ctx.setLineDash([]);
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(50, 210);
    ctx.lineTo(100, 210);
    ctx.lineWidth = 12;
    ctx.lineCap = 'round';
    ctx.stroke();

    // 図形のスタイルの設定
    ctx.fillStyle = 'pink'
    ctx.strokeStyle = '#f00';
    ctx.lineWidth = 8;
    ctx.lineJoin = 'round';

    // 影の設定
    ctx.shadowOffsetX = 4;
    ctx.shadowOffsetY = 4;
    ctx.shadowBlur = 4;
    ctx.shadowColor = 'rgba(0, 0, 0, 0.8)';

    // 図形の描画
    ctx.fillRect(50, 50, 50, 50);
    ctx.strokeRect(50, 50, 50, 50);

    // 画像の描画
    const logo = document.createElement('img');
    logo.src = 'img/logo.png';

    const sprite = document.createElement('img');
    sprite.src = 'img/sprite.png';

    logo.addEventListener('load', () => {
      ctx.shadowOffsetX = 0;
      ctx.shadowOffsetY = 0;
      ctx.shadowBlur = 0;
      ctx.drawImage(logo, 0, 0, 40, 40);

      ctx.drawImage(
        sprite,
        70 * 2, 70, 70, 70,
        50, 0, 35, 35
      );

      const pattern = ctx.createPattern(logo, 'repeat');
      ctx.fillStyle = pattern;
      ctx.fillRect(0, 240, canvas.width, 100);
    });

    draw_chara();
  }

  function draw_chara() {
    const canvas = document.getElementById('canvas3');
    const ctx = canvas3.getContext('2d');

    // キャラクターの描画
    // 描画領域のクリア
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = 'pink';
    ctx.fillRect(0, 0, 200, 200);

    ctx.beginPath();
    ctx.ellipse(100, 100, 40, 30, 0, 0, 2 * Math.PI);
    ctx.fillStyle = 'black';
    ctx.fill();

    ctx.beginPath();
    ctx.ellipse(80 + Math.sin(t / 30), 100, 8, 8, 0, 0, 2 * Math.PI);
    ctx.ellipse(120 + Math.sin(t / 30), 100, 8, 8, 0, 0, 2 * Math.PI);
    ctx.fillStyle = 'skyblue';
    ctx.fill();

    // 描画設定の保存
    ctx.save();

    // 座標空間の変更
    ctx.scale(0.5, 0.5);
    ctx.fillStyle = 'olive';
    ctx.translate(500, 0);
    ctx.rotate(45 / 180 * Math.PI);
    ctx.fillRect(0, 0, 200, 200);

    ctx.beginPath();
    ctx.ellipse(100, 100, 40, 30, 0, 0, 2 * Math.PI);
    ctx.fillStyle = 'black';
    ctx.fill();

    // 描画設定の復元
    ctx.restore();

    t++;
    setTimeout(draw_chara, 10);
  }

  draw();
}
