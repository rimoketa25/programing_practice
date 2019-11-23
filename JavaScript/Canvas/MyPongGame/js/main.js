'use strict';

$(() => {
  class Game {
    constructor(canvas) {
      this.ctx = canvas.getContext('2d');
      this.width = canvas.width;
      this.height = canvas.height;
    }

    // min ~ maxの間でランダムな整数を返却
    rand(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // 初期化関数
    init() {
      this.score = 0;
      this.isPlaying = true;
      this.myPaddle = new Paddle(100, 10);
      this.myBall = new Ball(this.rand(50, 250), this.rand(10, 80), 5, 5, 6);
      this.scoreLabel = new Label(10, 25);
    }

    // 描画領域のリセット関数
    clearStage() {
      this.ctx.fillStyle = '#AAEDFF';
      this.ctx.fillRect(0, 0, this.width, this.height);
    }

    // ループ関数
    update() {
      this.clearStage();
      this.scoreLabel.draw(this.ctx, 'SCORE: ' + this.score);

      this.myPaddle.draw(this.ctx);
      this.myPaddle.move();

      this.myBall.draw(this.ctx);
      this.isPlaying = this.myBall.move(this.width, this.height);
      this.score = this.myBall.checkCollision(this.myPaddle, this.score);

      // ループ処理
      this.timerId = setTimeout(() => {
        this.update();
      }, 30);

      // ループ処理の終了
      if (!this.isPlaying) {
        clearTimeout(this.timerId);
      }
    }
  }

  // Canvasの取得
  const canvas = document.getElementById('canvas');
  if (typeof canvas.getContext === 'undefined') {
    return;
  }

  // インスタンスの作成
  const game = new Game(canvas);

  // ボタンをクリックしたらスタート
  $('#btn').click(function () {
    $(this).fadeOut();
    game.init();
    game.update();
  });

  // マウス座標の取得
  let mouseX;
  $('body').mousemove(function (e) {
    mouseX = e.pageX;
  });

  // スコアラベル
  const Label = function (x, y) {
    // 描画位置
    this.x = x;
    this.y = y;

    // 描画関数
    this.draw = function (ctx, text) {
      // 描画設定
      ctx.font = 'bold 14px "Century Gothic"';
      ctx.fillStyle = '#00AAFF';
      ctx.textAlign = 'left';

      // 描画
      ctx.fillText(text, this.x, this.y);
    }
  }

  // ボール
  const Ball = function (x, y, vx, vy, r) {
    // ボールの座標
    this.x = x;
    this.y = y;

    // ボールの速度
    this.vx = vx;
    this.vy = vy;

    // ボールの半径
    this.r = r;

    // 描画関数
    this.draw = function (ctx) {
      // 描画設定
      ctx.fillStyle = '#FF0088';

      // 描画
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r, 0, 2 * Math.PI, true);
      ctx.fill();
    };

    // 移動関数
    this.move = function (c_width, c_height) {
      // 基本的な移動
      this.x += this.vx;
      this.y += this.vy;

      // 端との衝突判定
      if (this.x + this.r > c_width            // 左端
        || this.x - this.r < 0) {              // 右端
        this.vx *= -1;
      } else if (this.y - this.r < 0) {        // 上端
        this.vy *= -1;
      } else if (this.y + this.r > c_height) { // 下端
        $('#btn').text('REPLAY').fadeIn();
        return false;
      }
      return true;
    };

    // パドルとの衝突判定関数
    this.checkCollision = function (paddle, score) {
      if ((this.y + this.r > paddle.y && this.y + this.r < paddle.y + paddle.h)    // 垂直方向の判定
        && (this.x > paddle.x - paddle.w / 2 && this.x < paddle.x + paddle.w / 2)) // 水平方向の判定
      {
        this.vy *= -1;
        score++;

        //難易度調整
        if (score % 3 === 0) {
          this.vx *= 1.2;
          paddle.w *= 0.95;
        }
      }
      return score;
    }
  }

  // パドル
  const Paddle = function (w, h) {
    this.w = w;
    this.h = h;
    this.x = canvas.width / 2;
    this.y = canvas.height - 30;

    // 描画関数
    this.draw = function (ctx) {
      // 描画設定
      ctx.fillStyle = '#00AAFF';

      // 描画
      ctx.fillRect(this.x - this.w / 2, this.y, this.w, this.h);
    };

    // 移動関数
    this.move = function () {
      this.x = mouseX - $('#canvas').offset().left;
    }
  };
});