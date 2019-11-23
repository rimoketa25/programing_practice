'use strict';

{
  class Panel {
    constructor() {
      // 変数宣言
      this.timeoutId = undefined;

      // 要素の取得
      const section = document.createElement('section');
      const main = document.querySelector('main');

      // 各要素の作成
      section.classList.add('panel');

      this.img = document.createElement('img');
      this.img.src = this.getRandomImage();

      this.stop = document.createElement('div');
      this.stop.textContent = 'STOP';
      this.stop.classList.add('stop', 'inactive');

      // ストップボタンの設定
      this.stop.addEventListener('click', () => {
        if (this.stop.classList.contains('inactive')) {
          return;
        }
        this.stop.classList.add('inactive');
        clearTimeout(this.timeoutId);
        panelsLeft--;

        // 全てのパネルが止まれば結果判定
        if (panelsLeft === 0) {
          checkResult();
          spin.classList.remove('inactive');
          panelsLeft = 3;
        }
      })

      // 要素の追加
      section.appendChild(this.img);
      section.appendChild(this.stop);
      main.appendChild(section);
    }

    // ランダムに画像のパスを取得
    getRandomImage() {
      const images = [
        'img/seven.png',
        'img/cherry.png',
        'img/bell.png',
      ];

      return images[Math.floor(Math.random() * images.length)];
    }

    // 画像の回転を実行
    spin() {
      // パスの取得
      this.img.src = this.getRandomImage();

      // ループ処理
      this.timeoutId = setTimeout(() => {
        this.spin();
      }, 50)
    }

    // 結果判定処理
    isUnmatched(p1, p2) {
      return this.img.src !== p1.img.src && this.img.src !== p2.img.src;
    }

    // マッチしなかったパネルの処理
    unmatch() {
      this.img.classList.add('unmatched');
    }

    // リセット処理
    activate() {
      this.img.classList.remove('unmatched');
      this.stop.classList.remove('inactive');
    }
  }

  // 要素の取得
  const spin = document.getElementById('spin');

  // 変数宣言
  const panels = [
    new Panel(),
    new Panel(),
    new Panel(),
  ];
  let panelsLeft = 3;

  // スピンボタンの設定
  spin.addEventListener('click', () => {
    if (spin.classList.contains('inactive')) {
      return;
    }
    spin.classList.add('inactive');
    panels.forEach(panel => {
      panel.activate();
      panel.spin();
    });
  });

  // 結果判定実行
  function checkResult() {
    if (panels[0].isUnmatched(panels[1], panels[2])) {
      panels[0].unmatch();
    }
    if (panels[1].isUnmatched(panels[0], panels[2])) {
      panels[1].unmatch();
    }
    if (panels[2].isUnmatched(panels[0], panels[1])) {
      panels[2].unmatch();
    }
  }
}

