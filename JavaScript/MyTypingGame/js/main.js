'use strict';
{
  // 表示される単語一覧
  const words = [
    'green',
    'skyblue',
    'blue',
    'red',
    'black',
    'white',
  ];

  // 制限時間
  const timeLimit = 30 * 1000;

  // 変数宣言
  let word;
  let loc;
  let score;
  let miss;
  let cnt;
  let startTime;
  let isPlaying = false;

  // 要素の取得
  const target = document.getElementById('target');
  const scoreLabel = document.getElementById('score');
  const missLabel = document.getElementById('miss');
  const timerLabel = document.getElementById('timer');

  // 正解文字の更新
  function updateTarget() {
    let placeholder = '';
    for (let i = 0; i < loc; i++) {
      placeholder += '_';
    }
    target.textContent = placeholder + word.substring(loc);
  }

  // 結果の表示
  function showResult() {
    const type = score + miss;
    const accuracy = type === 0 ? 0 : (score / (type) * 100).toFixed(1);
    alert(`回答数：${cnt}単語\n正タイプ：${score}、　誤タイプ：${miss}、　正タイプ率：${accuracy}`);
  }

  // タイマー処理
  function updateTimer() {
    // 残り時間
    const timeLeft = startTime + timeLimit - Date.now();
    timerLabel.textContent = (timeLeft / 1000).toFixed(2);

    // ループ処理
    const timeoutId = setTimeout(() => {
      updateTimer();
    }, 10)

    // 残り時間がなくなったときの処理
    if (timeLeft < 0) {
      isPlaying = false;
      clearTimeout(timeoutId);
      timerLabel.textContent = '0.00';
      // 表示の遅延
      setTimeout(() => {
        showResult();
      }, 100);

      target.textContent = 'click to replay';
    }
  }

  // 初期化処理
  function init() {
    loc = 0;
    score = 0;
    miss = 0;
    cnt = 0;
    scoreLabel.textContent = score;
    missLabel.textContent = miss;
    word = words[Math.floor(Math.random() * words.length)];

    target.textContent = word;
    startTime = Date.now();
  }

  // ゲーム開始設定
  window.addEventListener('click', () => {
    if (isPlaying === true) {
      return;
    }
    isPlaying = true;

    // 初期化処理
    init();

    // 実行
    updateTimer();
  });

  // タイピング処理
  window.addEventListener('keydown', e => {
    if (isPlaying !== true) {
      return;
    }

    // 入力文字の判定
    if (e.key === word[loc]) {
      // 正しければ次の文字を設定
      loc++;
      if (loc === word.length) {
        // 最後まで入力したら次の単語を設定
        const old_word = word;
        do {
          word = words[Math.floor(Math.random() * words.length)];
        } while (old_word === word);

        loc = 0;
        cnt++;
      }
      updateTarget();
      score++;
      scoreLabel.textContent = score;
    } else {
      miss++;
      missLabel.textContent = miss;
    }
  });
}