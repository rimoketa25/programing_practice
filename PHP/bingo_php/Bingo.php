<?php
// 名前空間の設定
namespace MyApp;

// ビンゴクラス
class Bingo {
  // カードの作成
  public function create() {
    $nums = [];

    for ($i = 0; $i < 5; $i++) {
      // 各列に対応する数字を指定して配列の作成
      $col = range($i * 15 + 1, $i * 15 + 15);

      // 作成した配列の並び替え
      shuffle($col);

      // 先頭の５個を数字として設定
      $nums[$i] = array_slice($col, 0, 5);
    }

    // 真ん中の設定
    $nums[2][2] = "FREE";

    return $nums;
  }
}
