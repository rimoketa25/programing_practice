'use strict';

{
  // 要素の取得
  const question = document.getElementById('question');
  const choices = document.getElementById('choices');
  const btn = document.getElementById('btn');
  const result = document.getElementById('result');
  const scoreLabel = document.querySelector('#result > p');

  // 問題の設定
  const quizSet = shuffle([
    { q: '都道府県は全部でいくつあるか？', c: ['47', '46', '48'] },
    { q: '一番大きい県はどこ？', c: ['岩手県', '福島県', '長野県'] },
    { q: '一番小さい都府県はどこ？', c: ['香川県', '大阪府', '東京都'] },
  ]);

  // 変数宣言
  let currentNum = 0;
  let isAnswered;
  let score = 0;

  // フィッシャー・イェーツのシャッフル
  function shuffle(arr) {
    let rnd;
    for (let i = arr.length - 1; i > 0; i--) {
      rnd = Math.floor(Math.random() * (i + 1));
      [arr[rnd], arr[i]] = [arr[i], arr[rnd]];
    }
    return arr;
  }

  // 正誤チェック
  function checkAnswer(li) {
    // 既に選択肢が押されていたら処理しない
    if (isAnswered) {
      return;
    }
    isAnswered = true;

    if (li.textContent === quizSet[currentNum].c[0]) {
      // 正解のとき
      li.classList.add('正解！');
      score++;
    } else {
      // 不正解のとき
      li.classList.add('不正解…');
    }

    // 次へボタンを押せるようにする
    btn.classList.remove('disabled')
  }

  // 画面描画
  function setQuiz() {
    isAnswered = false;
    question.textContent = quizSet[currentNum].q;

    // 描画済み選択肢のリセット
    while (choices.firstChild) {
      choices.removeChild(choices.firstChild);
    }

    // 選択肢の描画
    const shuffledChoices = shuffle([...quizSet[currentNum].c]);
    shuffledChoices.forEach(choice => {
      const li = document.createElement('li');
      li.textContent = choice;
      li.addEventListener('click', () => {
        checkAnswer(li);
      });
      choices.appendChild(li);
    });

    // 最後の問題であればボタンの表示を変更
    if (currentNum === quizSet.length - 1) {
      btn.textContent = 'Show Score';
    }
  }

  // 実行
  setQuiz();

  btn.addEventListener('click', () => {
    // 回答を選択するまでは処理をしない
    if (btn.classList.contains('disabled')) {
      return;
    }

    // 次の問題に行ったらボタンを押せないようにする
    btn.classList.add('disabled');

    if (currentNum === quizSet.length - 1) {
      // 最後の問題であれば結果の表示
      result.classList.remove('hidden');
      scoreLabel.textContent = `Score: ${score} / ${quizSet.length}`;
    } else {
      // 途中であれば次の問題の描画
      currentNum++;
      setQuiz();
    }
  });
}