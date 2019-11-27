'use strict';

(() => {
  // 時計描画クラス
  class ClockDrawer {
    // コンストラクター
    constructor(canvas) {
      this.ctx = canvas.getContext('2d');
      this.width = canvas.width;
      this.height = canvas.height;
    }

    // 描画関数
    draw(angle, func) {
      // 描画領域の保存
      this.ctx.save();

      // 中心の移動と時間に合わせた回転
      this.ctx.translate(this.width / 2, this.height / 2);
      this.ctx.rotate(Math.PI / 180 * angle);

      // 描画
      this.ctx.beginPath();
      func(this.ctx);
      this.ctx.stroke();

      // 描画領域の読み込み
      this.ctx.restore();
    }

    // 数字の描画関数
    drawNumber(angle, rotate, func) {
      // 描画領域の保存
      this.ctx.save();

      // 中心の移動
      this.ctx.translate(this.width / 2, this.height / 2);
      this.ctx.translate(rotate * Math.cos(angle), rotate * Math.sin(angle));

      // 描画
      this.ctx.beginPath();
      func(this.ctx);
      this.ctx.stroke();

      // 描画領域の読み込み
      this.ctx.restore();
    }

    // 描画領域のリセット
    clear() {
      this.ctx.clearRect(0, 0, this.width, this.height);
    }
  }

  // 時計クラス
  class Clock {
    constructor(drawer) {
      this.r = 100; // 半径
      this.drawer = drawer;
    }

    // 盤面の描画関数
    drawFace() {
      // 線の描画
      for (let angle = 0; angle < 360; angle += 6) {
        this.drawer.draw(angle, ctx => {
          // 描画位置の移動
          ctx.moveTo(0, -this.r);

          if (angle % 30 === 0) {
            // 30度毎に長い線の描画
            ctx.lineWidth = 2;
            ctx.lineTo(0, -this.r + 10);
          } else {
            // それ以外は短い線の描画
            ctx.lineTo(0, -this.r + 5);
          }
        });
      }

      // 数字の描画
      for (let i = 0; i < 12; i++) {
        let angle = Math.PI / 180 * (30 * i - 90);

        this.drawer.drawNumber(angle, this.r - 25, ctx => {
          ctx.font = '13px Arial';
          ctx.textAlign = 'center';
          ctx.fillText(i || 12, 0, 5);
        });
      }
    }

    // 針の描画関数
    drawHands() {
      // 時針
      this.drawer.draw(this.h * 30 + this.m * 0.5, ctx => {
        ctx.lineWidth = 6;
        ctx.moveTo(0, 10);
        ctx.lineTo(0, -this.r + 50);
      });

      // 分針
      this.drawer.draw(this.m * 6, ctx => {
        ctx.lineWidth = 4;
        ctx.moveTo(0, 10);
        ctx.lineTo(0, -this.r + 30);
      });

      // 秒針
      this.drawer.draw(this.s * 6, ctx => {
        ctx.strokeStyle = 'red';
        ctx.moveTo(0, 20);
        ctx.lineTo(0, -this.r + 20);
      });
    }

    // 時刻の更新関数
    update() {
      this.h = (new Date()).getHours();
      this.m = (new Date()).getMinutes();
      this.s = (new Date()).getSeconds();
    }

    // 実行関数
    run() {
      // 時刻の更新
      this.update();

      // 描画領域のリセット
      this.drawer.clear();

      // 盤面の描画
      this.drawFace();

      // 針の描画
      this.drawHands();

      // ループ処理
      setTimeout(() => {
        this.run();
      }, 100);
    }
  }

  // Canvasの取得
  const canvas = document.querySelector('canvas');
  if (typeof canvas.getContext === 'undefined') {
    return;
  }

  // インスタンスの作成
  const clock = new Clock(new ClockDrawer(canvas));

  // 実行
  clock.run();
})();