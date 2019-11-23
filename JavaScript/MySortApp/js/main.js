'use strict';

{
  // 要素の取得
  const ths = document.querySelectorAll('th');
  const tbody = document.querySelector('tbody');

  // ソート順の制御用
  let sortOrder = 1; // 1: 昇順、-1: 降順

  // tbodyの再描画
  function rebuildTbody(rows) {
    // 最初の子要素がある限り
    while (tbody.firstChild) {
      // その子要素を削除する
      tbody.removeChild(tbody.firstChild);
    }

    // 並び変えた結果を子要素として追加
    rows.forEach(row => {
      tbody.appendChild(row);
    });
  }

  // thのクラスの更新
  function updateClassName(th) {
    // thのクラスのリセット
    ths.forEach(th => {
      th.className = '';
    })

    // ソート順に合わせてクラスの付与
    th.classList.add(sortOrder === 1 ? 'asc' : 'desc');
  }

  // ソート実行
  function compare(a, b, col, type) {
    let _a = a.children[col].textContent;
    let _b = b.children[col].textContent;

    // 種別が数字であれば、数字に変換
    if (type === "number") {
      _a = _a * 1;
      _b = _b * 1;
    }
    // 種別が文字であれば、小文字に統一
    if (type === "string") {
      _a = _a.toLowerCase();
      _b = _b.toLowerCase();
    }

    // ソート
    if (_a < _b) {
      return -1;
    }
    if (_a > _b) {
      return 1;
    }
    return 0;
  }

  // 行要素のソート
  function sortRows(th) {
    // クリックされた列の番号と種別の取得
    const col = th.cellIndex;
    const type = th.dataset.type;

    // 並び替え用の配列の作成
    const rows = Array.prototype.slice.call(document.querySelectorAll('tbody > tr'));

    // ソート処理
    rows.sort(function (a, b) {
      return compare(a, b, col, type) * sortOrder;
    });

    return rows;
  }

  // クリック時のイベント設定
  function setup() {
    ths.forEach(th => {
      th.addEventListener('click', () => {
        // 行要素のソート
        const rows = sortRows(th);

        // tbodyの再描画
        rebuildTbody(rows);

        // thのクラスの更新
        updateClassName(th);

        // ソート順の反転
        sortOrder *= -1;
      });
    });
  }

  // 実行
  setup();
}