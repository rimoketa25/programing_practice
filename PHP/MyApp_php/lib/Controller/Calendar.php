<?php
// 名前空間の指定
namespace MyApp\Controller;
use Carbon\Carbon;

// カレンダークラス
class Calendar extends \MyApp\Controller {
  // 変数宣言
  public $prev;
  public $next;
  public $year;
  public $month;
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
      $this->_thisMonth = new Carbon($_GET['t']);
    } catch (\Exception $e) {
      // 正常に取得できなければ、今月としてオブジェクトの作成
      $this->_thisMonth = Carbon::now();
    }

    // 月移動のリンクの作成
    $this->prev = $this->_createPrevLink();
    $this->next = $this->_createNextLink();

    // 表示する年月の設定
    $this->year = $this->_thisMonth->year;
    $this->month = $this->_thisMonth->month;
    $this->yearMonth = $this->_thisMonth->format('F Y');
  }

  // 前月へのリンクの作成
  private function _createPrevLink() {
    $dt = $this->_thisMonth->copy()->subMonth();
    return $dt->format('Y-m');
  }

  // 次月へのリンクの作成
  private function _createNextLink() {
    $dt = $this->_thisMonth->copy()->addMonth();
    return $dt->format('Y-m');

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
    $lastDayOfPrevMonth = $this->_thisMonth->copy()->subMonth()->endOfMonth();

    // 最終日から直近の土曜日までの日付を取得
    while ($lastDayOfPrevMonth->dayOfWeek < 6) {
      $tail = sprintf('<td class="gray">%d</td>', $lastDayOfPrevMonth->day) . $tail;

      // 一日減らす
      $lastDayOfPrevMonth->subDay();
    }
    return $tail;
  }

  // 今月の表示日の作成
  private function _getBody() {
    $body = '';
    $today = Carbon::now();

    // 今月のすべての日付を取得
    $period = new \DatePeriod(
      $this->_thisMonth->copy()->startOfMonth(), // 期間の最初の日
      new \DateInterval('P1D'), // 日付を作成する間隔
      $this->_thisMonth->copy()->addMonth()->startOfMonth() // 期間の最後の日
    );

    // 表示する要素の作成
    foreach ($period as $day) {
      // ７日ごとに改行
      if ($day->dayOfWeek === 0) { $body .= '</tr><tr>'; }

      // 表示日が今日であった場合クラスの付与
      $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';

      // 表示する要素の作成
      $body .= sprintf('<td class="youbi_%d %s">%d</td>', $day->dayOfWeek, $todayClass, $day->day);
    }
    return $body;
  }

  // 次月の表示日の作成
  private function _getHead() {
    $head = '';

    // 次月の初日の取得
    $firstDayOfNextMonth = $this->_thisMonth->copy()->addMonth()->startOfMonth();

    // 最終日から直近日曜日までの日付を取得
    while ($firstDayOfNextMonth->dayOfWeek > 0) {
      $head .= sprintf('<td class="gray">%d</td>', $firstDayOfNextMonth->day);

      // 一日増やす
      $firstDayOfNextMonth->addDay();
    }
    return $head;
  }
}
