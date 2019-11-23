'use strict';
{
  // パネルクラス
  class Panel {
    // コンストラクター
    constructor(game) {
      this.game = game;
      this.el = document.createElement('li');
      this.el.classList.add('pressed');
      this.el.addEventListener('click', () => {
        this.check();
      });
    }

    getEl() {
      return this.el;
    }

    // パネルの作成
    activate(num) {
      this.el.classList.remove('pressed');
      this.el.textContent = num;
    }

    // 正誤チェック
    check() {
      // クリックしたパネルの数字と押すべき数字が等しければ
      if (this.game.getCurrentNum() === parseInt(this.el.textContent, 10)) {
        // 押すべき数字の更新
        this.el.classList.add('pressed');
        this.game.addCurrentNum();
        if (this.game.getCurrentNum() === this.game.getLevel() ** 2 + 1) {
          // 全てのパネルを押せばタイマーの終了
          clearTimeout(this.game.getTimeoutId());
        }
      }
    }
  }

  // ボードクラス
  class Board {
    // コンストラクター
    constructor(game) {
      this.game = game;
      this.panels = [];

      // 全パネルの作成
      for (let i = 0; i < this.game.getLevel() ** 2; i++) {
        this.panels.push(new Panel(this.game));
      }

      // ボードにパネルの配置
      this.setup();
    }

    // パネルの配置
    setup() {
      const board = document.getElementById('board');
      this.panels.forEach(panel => {
        board.appendChild(panel.getEl());
      });
    }

    // ゲームの実行
    activate() {
      // 全数字の決定
      const nums = [];
      for (let i = 1; i <= this.game.getLevel() ** 2; i++) {
        nums.push(i);
      }

      //パネルの作成
      this.panels.forEach(panel => {
        const num = nums.splice(Math.floor(Math.random() * nums.length), 1)[0];
        panel.activate(num);
      });
    }
  }

  // ゲームクラス
  class Game {
    constructor(level) {
      // 要素の取得
      const btn = document.getElementById('btn');

      // 変数宣言
      this.level = level;
      this.currentNum = undefined;
      this.startTime = undefined;
      this.timeoutId = undefined;

      // インスタンス作成
      this.board = new Board(this);

      // ゲームの実行
      btn.addEventListener('click', () => {
        this.start();
      });

      // スタイルの調整
      this.setup();
    }

    // スタイルの調整
    setup() {
      const container = document.getElementById('container');
      const PANEL_WIDTH = 50;
      const BOARD_PADDING = 10;
      container.style.width = PANEL_WIDTH * this.level + BOARD_PADDING * 2 + 'px';
    }

    // 初期化
    start() {
      // タイマーのリセット
      if (typeof this.timeoutId !== 'undefined') {
        clearTimeout(this.timeoutId);
      }

      this.currentNum = 1;
      this.board.activate();

      // 現在時刻を取得してタイマー実行
      this.startTime = Date.now();
      this.runTimer();
    }

    // タイマー処理
    runTimer() {
      // 表示タイマーの設定
      const timer = document.getElementById('timer');
      timer.textContent = ((Date.now() - this.startTime) / 1000).toFixed(2);

      // ループ処理
      this.timeoutId = setTimeout(() => {
        this.runTimer();
      }, 10);
    }

    // レベル変更
    chageLavel(level) {
      // レベルの変更
      this.level = level;

      // ボード内のパネルを全消去
      const board = document.getElementById('board');
      while (board.firstChild) {
        board.removeChild(board.firstChild);
      }

      // ボードとパネルの再作成
      this.board = new Board(this);

      // ボードの幅の再調整
      this.setup();
    }

    addCurrentNum() {
      this.currentNum++;
    }

    getCurrentNum() {
      return this.currentNum;
    }

    getTimeoutId() {
      return this.timeoutId;
    }

    getLevel() {
      return this.level;
    }
  }

  // インスタンス作成
  let game = new Game(3);

  // レベル変更
  $('#level').change(function () {
    game.chageLavel($(this).val());
  });
}