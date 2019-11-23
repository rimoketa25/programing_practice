'use strict';
{
  // 要素の取得
  const timer = document.getElementById('timer');
  const start = document.getElementById('start');
  const rap = document.getElementById('rap');
  const stop = document.getElementById('stop');
  const reset = document.getElementById('reset');
  const rapTimelist = document.getElementById('rapTimelist');

  // 変数宣言
  let startTime;
  let rapTime;
  let elapsedTime = 0;
  let timeoutId;

  // 表示時刻の取得
  function getTime(time) {
    const m = String(time.getMinutes()).padStart(2, '0');
    const s = String(time.getSeconds()).padStart(2, '0');
    const ms = String(time.getMilliseconds()).padStart(3, '0');
    return `${m}:${s}.${ms}`;
  }

  // タイマー処理
  function countUp() {
    const time = new Date(Date.now() - startTime + elapsedTime);

    // 経過時間の表示
    timer.textContent = getTime(time);

    // ループ処理
    timeoutId = setTimeout(() => {
      countUp();
    }, 10);
  }

  // ラップタイムの表示
  function setRapTime() {
    const time = new Date(Date.now() - rapTime);
    const li = document.createElement('li');
    li.textContent = getTime(time);
    rapTimelist.appendChild(li);
  }

    // ラップタイムの消去
    function removeRapTime() {
        // 最初の子要素がある限り
        while (rapTimelist.firstChild) {
          // その子要素を削除する
          rapTimelist.removeChild(rapTimelist.firstChild);
        }
    }

  // ボタンの初期化
  function setButtonStateInitial() {
    start.classList.remove('inactive');
    rap.classList.add('inactive');
    stop.classList.add('inactive');
    reset.classList.add('inactive');
  }

  // 動作中のボタンの設定
  function setButtonStateRunnning() {
    start.classList.add('inactive');
    rap.classList.remove('inactive');
    stop.classList.remove('inactive');
    reset.classList.add('inactive');
  }

  // 停止中のボタンの設定
  function setButtonStateStop() {
    start.classList.remove('inactive');
    rap.classList.add('inactive');
    stop.classList.add('inactive');
    reset.classList.remove('inactive');
  }

  // 初期化
  setButtonStateInitial();

  // スタートボタンの設定
  start.addEventListener('click', () => {
    if (start.classList.contains('inactive') === true) {
      return;
    }
    startTime = Date.now();
    rapTime = Date.now();
    setButtonStateRunnning();
    countUp();
  });

  // ラップボタンの設定
  rap.addEventListener('click', () => {
    if (rap.classList.contains('inactive') === true) {
      return;
    }
    setRapTime();
    rapTime = Date.now();
  });

  // ストップボタンの設定
  stop.addEventListener('click', () => {
    if (stop.classList.contains('inactive') === true) {
      return;
    }
    clearTimeout(timeoutId);
    elapsedTime += Date.now() - startTime;
    setButtonStateStop();
  });

  // リセットボタンの設定
  reset.addEventListener('click', () => {
    if (reset.classList.contains('inactive') === true) {
      return;
    }
    timer.textContent = '00:00.000';
    elapsedTime = 0;
    removeRapTime();
    setButtonStateInitial();
  });
}