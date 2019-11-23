'use strict';

{
  // 表示する画像
  const images = [
    'img/pic00.png',
    'img/pic01.png',
    'img/pic02.png',
    'img/pic03.png',
    'img/pic04.png',
    'img/pic05.png',
    'img/pic06.png',
    'img/pic07.png',
  ];

  // 要素の取得
  const play = document.getElementById('play');
  const pause = document.getElementById('pause');
  const next = document.getElementById('next');
  const prev = document.getElementById('prev');
  const thumbnails = document.querySelector('.thumbnails');

  // 変数宣言
  let currentNum = 0;
  let timeoutId;

  // メイン画像の表示
  function setMainImage(image) {
    document.querySelector('main img').src = image;
  }

  // カレントクラスの追加
  function addCurrentClass() {
    document.querySelectorAll('.thumbnails li')[currentNum]
      .classList.add('current');
  }

  // カレントクラスの削除
  function removeCurrentClass() {
    document.querySelectorAll('.thumbnails li')[currentNum]
      .classList.remove('current');
  }

  // スライドショーの再生
  function playSlideshow() {
    timeoutId = setTimeout(() => {
      next.click();
      playSlideshow();
    }, 1000);
  }

  // メイン画像の設定
  setMainImage(images[currentNum]);

  // サムネイル画像の設定
  images.forEach((image, index) => {
    const li = document.createElement('li');
    const img = document.createElement('img');

    // 表示されている画像の設定
    if (index === currentNum) {
      li.classList.add('current');
    }

    // サムネイル画像をクリックした時の設定
    li.addEventListener('click', () => {
      setMainImage(image);
      removeCurrentClass();
      currentNum = index;
      addCurrentClass();
    });

    // サムネイル画像に追加
    img.src = image;
    li.appendChild(img);
    thumbnails.appendChild(li);
  });

  // 再生ボタンの設定
  play.addEventListener('click', () => {
    play.classList.add('hidden');
    pause.classList.remove('hidden');
    playSlideshow();
  });

  // 停止ボタンの設定
  pause.addEventListener('click', () => {
    play.classList.remove('hidden');
    pause.classList.add('hidden');
    clearTimeout(timeoutId);
  });

  // 次へボタンの設定
  next.addEventListener('click', () => {
    removeCurrentClass();
    currentNum++;

    // 最後まで来たら最初に戻す
    if (currentNum === images.length) {
      currentNum = 0;
    }
    addCurrentClass();
    setMainImage(images[currentNum]);
  })

  // 前へボタンの設定
  prev.addEventListener('click', () => {
    removeCurrentClass();
    currentNum--;

    // 最初まで来たら最後に戻す
    if (currentNum < 0) {
      currentNum = images.length - 1;
    }
    addCurrentClass();
    setMainImage(images[currentNum]);
  })
}