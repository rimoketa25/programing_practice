'use strict';

(() => {

  class Panel {
    constructor(canvas) {
      this.ctx = canvas.getContext('2d');
      this.width = canvas.width;
      this.height = canvas.height;
      this.count = 0;
    }

    // 初期化関数
    init() {
      // 分割数の取得
      this.dim = Math.floor(this.count / 3) + 2;

      // パネルサイズの設定
      this.size = Math.floor(this.width / this.dim);

      // 正解のパネルの設定
      this.answer = [
        Math.floor(Math.random() * this.dim),
        Math.floor(Math.random() * this.dim)
      ];
    }

    // 描画関数
    draw() {
      // パネルの設定
      const offset = 2;
      const hue = Math.random() * 360;
      const lightness = Math.max(75 - this.count, 53);
      const baseColor = 'hsl(' + hue + ', 80%, 50%)';
      const answerColor = 'hsl(' + hue + ', 80%, ' + lightness + '%)';

      // 描画領域のリセット
      this.ctx.clearRect(0, 0, this.width, this.height);

      for (let x = 0; x < this.dim; x++) {
        for (let y = 0; y < this.dim; y++) {
          if (this.answer[0] === x && this.answer[1] === y) {
            // 正解のパネル色の設定
            this.ctx.fillStyle = answerColor;
          } else {
            // 不正解のパネル色の設定
            this.ctx.fillStyle = baseColor;
          }

          // パネルの描画
          this.ctx.fillRect(
            this.size * x + offset,
            this.size * y + offset,
            this.size - offset * 2,
            this.size - offset * 2
          );
        }
      }
    }

    // 判定関数
    check(x, y) {
      // 正誤判定
      if (
        this.answer[0] === Math.floor(x / this.size) &&
        this.answer[1] === Math.floor(y / this.size)
      ) {// 正解の場合
        // 正解数をカウントアップして再描画
        this.count++;
        this.run();
      } else { // 不正解の場合
        // ボタンと正解数の表示
        document.getElementById('replay').className = '';
        alert('Your score: ' + this.count);
        isPlaying = false;
      }
    }

    // 実行関数
    run() {
      // 初期化
      this.init();

      // 描画
      this.draw();
    }
  }
  
  // Canvasの取得
  const stage = document.getElementById('stage');
  if (typeof stage.getContext === 'undefined') {
    return;
  }

  // リプレイボタン
  stage.addEventListener('click', function (e) {
    // 描画領域サイズの取得
    const rect = e.target.getBoundingClientRect();

    // クリック位置の座標取得（スクロールも考慮）
    const x = e.pageX - rect.left - window.scrollX;
    const y = e.pageY - rect.top - window.scrollY;

    // 実行可能かの判定
    if (isPlaying === false) {
      return;
    }

    // 正誤判定
    panel.check(x, y);
  });

  // インスタンスの作成
  const panel = new Panel(stage);

  // 実行
  let isPlaying = true;
  panel.run();

})();
