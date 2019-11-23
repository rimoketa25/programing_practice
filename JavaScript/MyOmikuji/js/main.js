'use strict';
{
  const btn1 = document.getElementById('btn1');
  const btn2 = document.getElementById('btn2');

  // 等確率のおみくじ
  btn1.addEventListener('click', () => {
    const results = [
      '大吉', '吉', '中吉', '小吉', '半吉', '末吉', '末小吉',
      '平', '凶', '小凶', '半凶', '末凶', '大凶'
    ];
    const n = Math.floor(Math.random() * results.length);
    btn1.textContent = results[n];
  });

  // 確率操作されたおみくじ
  btn2.addEventListener('click', () => {
    const rnd = Math.random();
    if (rnd < 0.05) {
      btn2.textContent = '大吉';
    } else if (rnd < 0.2) {
      btn2.textContent = '中吉';
    } else {
      btn2.textContent = '凶';
    }
  });
}