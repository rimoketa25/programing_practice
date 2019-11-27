'use strict';

{
  const Maze = function (col, row) {
    // 迷路作成用の配列
    this.map = [];
    this.points = [
      [0, -1], // 下
      [0, 1], // 上
      [1, 0], // 右
      [-1, 0] // 左
    ];

    // 迷路のサイズ
    this.col = col;
    this.row = row;

    // スタートとゴールの座標
    this.startX = 0;
    this.startY = 0;
    this.goalX = col - 1;
    this.goalY = row - 1;

    // 乱数作成関数
    this.rand = function (n) {
      return Math.floor(Math.random() * (n + 1));
    };

    // 初期化関数（棒倒し法で迷路を作成）
    this.init = function () {
      let direction = [];

      // 迷路の初期化
      for (let x = 0; x < col; x++) {
        this.map[x] = [];
        for (let y = 0; y < row; y++) {
          this.map[x][y] = 0;
        }
      }

      // 一つ飛びに壁（棒）を作成
      for (let x = 1; x < col; x += 2) {
        for (let y = 1; y < row; y += 2) {
          this.map[x][y] = 1;
        }
      }

      for (let x = 1; x < col; x += 2) {
        for (let y = 1; y < row; y += 2) {
          do {
            if (x === 1) {
              // 1列目の棒を倒す方向を決める（上下左右）
              direction = this.points[this.rand(3)];
            } else {
              // 2列目以降の棒を倒す方向を決める（左以外）
              direction = this.points[this.rand(2)];
            }
          } while (this.map[x + direction[0]][y + direction[1]] === 1); // 倒す方向が壁であればやり直し

          // 棒を倒す
          this.map[x + direction[0]][y + direction[1]] = 1;
        }
      }
    };

    // 迷路の描画
    this.draw = function () {
      const view = new View();
      view.draw(this);
    };
  };

  const Player = function () {
    // Playerの座標
    this.position = [0, 0];

    // 移動可否判定
    this.check = function (move, maze) {
      // 移動後の座標
      const x = this.position[0] + move[0];
      const y = this.position[1] + move[1];

      // 判定
      if (x < 0 || x > maze.goalX
        || y < 0 || y > maze.goalY
        || maze.map[x][y] === 1) {
        // 移動先が壁なら移動不可
        return;
      } else {
        // 移動先が壁でなければ位置を更新
        this.position[0] = x;
        this.position[1] = y;

        // 再描画
        maze.draw();
        this.draw();
      }
    };

    // プレイヤーの描画
    this.draw = function () {
      const view = new View();
      view.drawPlayer(this.position);
    };
  }

  const View = function () {
    // 描画設定
    this.wallSize = 10;
    this.wallColor = '#3261AB';
    this.routeColor = '#FF0088';

    // Canvasの取得
    this.canvas = document.getElementById('mycanvas');
    if (!this.canvas || !this.canvas.getContext) {
      return false;
    }
    this.ctx = this.canvas.getContext('2d');

    // 迷路の描画
    this.draw = function (maze) {
      // 描画領域の設定
      this.canvas.width = (maze.col + 2) * this.wallSize;
      this.canvas.height = (maze.row + 2) * this.wallSize;

      // 上下の壁の描画
      for (let x = 0; x < maze.col + 2; x++) {
        this.drawWall(x, 0);
        this.drawWall(x, maze.row + 1);
      }

      // 左右の壁の描画
      for (let y = 0; y < maze.row + 2; y++) {
        this.drawWall(0, y);
        this.drawWall(maze.col + 1, y);
      }

      // 迷路の内部の描画
      for (let x = 0; x < maze.col; x++) {
        for (let y = 0; y < maze.row; y++) {
          if (maze.map[x][y] === 1) {
            // 壁の描画
            this.drawWall(x + 1, y + 1);
          }
          if ((x === maze.startX && y === maze.startY) || (x === maze.goalX && y === maze.goalY)) {
            // スタートとゴールの描画
            this.drawRoute(x + 1, y + 1);
          }
        }
      }
    };

    // 壁の描画関数
    this.drawWall = function (x, y) {
      this.ctx.fillStyle = this.wallColor;
      this.drawRect(x, y);
    };

    // スタートゴールの描画関数
    this.drawRoute = function (x, y) {
      this.ctx.fillStyle = this.routeColor;
      this.drawRect(x, y);
    };

    // 描画関数
    this.drawRect = function (x, y) {
      this.ctx.fillRect(
        x * this.wallSize,
        y * this.wallSize,
        this.wallSize,
        this.wallSize);
    };

    // Playerの描画
    this.drawPlayer = function (player) {
      // 描画座標の決定
      const x = player[0] * this.wallSize + 15;
      const y = player[1] * this.wallSize + 15;

      // 描画設定
      this.ctx.fillStyle = '#000000';

      // 描画
      this.ctx.beginPath();
      this.ctx.arc(x, y, 4, 0, 2 * Math.PI, true);
      this.ctx.fill();
    }
  };

  // 再描画関数
  function reset(level) {
    const maze = new Maze(level, level);
    const player = new Player(maze);
    maze.init();
    maze.draw();
    player.draw();

    document.body.onkeydown = function (e) {
      // 十字キーによる移動量
      const moovKeys = {
        37: [-1, 0], //left
        39: [1, 0], //right
        40: [0, 1], //down
        38: [0, -1], //up
      };
      if (moovKeys[e.keyCode]) {
        player.check(moovKeys[e.keyCode], maze);

        // Goalに着いたかどうかの判定
        if (player.position[0] === maze.goalX && player.position[1] === maze.goalY) {
          // 表示の遅延
          setTimeout(() => {
            alert('Complete!!');
          }, 100);
        }
      }
    }
  }

  let level = 11;

  // 初期描画
  reset(level);

  $('#level').change(function () {
    level = $(this).val();
  });

  // リセットボタンクリック時の描画
  document.getElementById('reset').addEventListener('click', () => {
    reset(Number(level));
  });

}