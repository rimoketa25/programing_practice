<?php
// 名前空間の指定
namespace MyApp\Controller;

// カレンダークラス
class Calendar extends \MyApp\Controller {
  // 変数宣言
  public $prev;
  public $next;
  public $yearMonth;
  private $_thisMonth;

  // コンストラクター
  public function __construct() {
    try {
      // 値の取得やフォーマットの判定
      if (!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) {
        throw new \Exception();
      }

      // 指定された月のオブジェクトの作成
      $this->_thisMonth = new \DateTime($_GET['t']);
    } catch (\Exception $e) {
      // 正常に取得できなければ、今月としてオブジェクトの作成
      $this->_thisMonth = new \DateTime('first day of this month');
    }

    // 月移動のリンクの作成
    $this->prev = $this->_createPrevLink();
    $this->next = $this->_createNextLink();

    // 表示する年月の設定
    $this->yearMonth = $this->_thisMonth->format('F Y');
  }

  // 前月へのリンクの作成
  private function _createPrevLink() {
    $dt = clone $this->_thisMonth;
    return $dt->modify('-1 month')->format('Y-m');
  }

  // 次月へのリンクの作成
  private function _createNextLink() {
    $dt = clone $this->_thisMonth;
    return $dt->modify('+1 month')->format('Y-m');
  }

  // HTML要素の表示
  public function show() {
    $tail = $this->_getTail(); // 前月
    $body = $this->_getBody(); // 今月
    $head = $this->_getHead(); // 次月

    // 要素の作成
    $html = '<tr>' . $tail . $body . $head . '</tr>';

    // 表示
    echo $html;
  }

  // 前月の表示日の作成
  private function _getTail() {
    $tail = '';

    // 前月の最終日の取得
    $lastDayOfPrevMonth = new \DateTime('last day of ' . $this->yearMonth . ' -1 month');

    // 最終日から直近の土曜日までの日付を取得
    while ($lastDayOfPrevMonth->format('w') < 6) {
      $tail = sprintf('<td class="gray">%d</td>', $lastDayOfPrevMonth->format('d')) . $tail;

      // 一日減らす
      $lastDayOfPrevMonth->sub(new \DateInterval('P1D'));
    }
    return $tail;
  }

  // 今月の表示日の作成
  private function _getBody() {
    $body = '';
    $today = new \DateTime('today');

    // 今月のすべての日付を取得
    $period = new \DatePeriod(
      new \DateTime('first day of ' . $this->yearMonth), // 期間の最初の日
      new \DateInterval('P1D'), // 日付を作成する間隔
      new \DateTime('first day of ' . $this->yearMonth . ' +1 month') // 期間の最後の日
    );

    // 表示する要素の作成
    foreach ($period as $day) {
      // ７日ごとに改行
      if ($day->format('w') === '0') { $body .= '</tr><tr>'; }

      // 表示日が今日であった場合クラスの付与
      $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';

      // 表示する要素の作成
      $body .= sprintf('<td class="youbi_%d %s">%d</td>', $day->format('w'), $todayClass, $day->format('d'));
    }
    return $body;
  }

  // 次月の表示日の作成
  private function _getHead() {
    $head = '';

    // 次月の初日の取得
    $firstDayOfNextMonth = new \DateTime('first day of ' . $this->yearMonth . ' +1 month');

    // 最終日から直近日曜日までの日付を取得
    while ($firstDayOfNextMonth->format('w') > 0) {
      $head .= sprintf('<td class="gray">%d</td>', $firstDayOfNextMonth->format('d'));

      // 一日増やす
      $firstDayOfNextMonth->add(new \DateInterval('P1D'));
    }
    return $head;
  }
}
