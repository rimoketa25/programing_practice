(function() {
  'use strict';

  // 要素の取得
  const cmds = document.getElementsByClassName('del');

  for (let i = 0; i < cmds.length; i++) {
    cmds[i].addEventListener('click', function(e) {
      // aタグの抑制
      e.preventDefault();

      // 確認表示
      if (confirm('are you sure?')) {
        // OKなら削除実行
        document.getElementById('form_' + this.dataset.id).submit();
      }
    });
  }
})();
