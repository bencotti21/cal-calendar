<?php

namespace App\Libraries;

use Carbon\Carbon;

class Calendar {

  private $carbon;

  function __construct($date) {
    $this->carbon = new Carbon($date);
  }

  public function getYear() {
    return $this->carbon->year;
  }

  public function getMonth() {
    return $this->carbon->month;
  }

  public function getCalendar() {
    $calendar = [];

    // 月初めの日
    $firstDay = $this->carbon->copy()->firstOfMonth();
    // 月末の日
    $lastDay = $this->carbon->copy()->lastOfMonth();

    // 週の開始、終了の曜日の設定
    Carbon::setWeekStartsAt(Carbon::SUNDAY);
    Carbon::setWeekEndsAt(Carbon::SATURDAY);

    // 週の開始日が月末より前の日付の間、ループする
    for ($date = $firstDay->copy(); $date->copy()->startOfWeek()->lte($lastDay); $date->addDay(7)) {
      // 週の開始日
      $startDay = $date->copy()->startOfWeek();
      // 週の終了日
      $endDay = $date->copy()->endOfWeek();

      $calendar[] = $this->getWeek($startDay, $endDay);
    }

    return $calendar;
  }

  protected function getWeek(Carbon $startDay, Carbon $endDay) {
    $week = [];

    for ($day = $startDay->copy();$day->lte($endDay);$day->addDay()) {
      // 当月以外の月は空文字を格納する
      if ($day->month != $this->carbon->month) {
        $week[] = "";
        continue;
      }

      $week[] = $day->copy()->day;
    }

    return $week;
  }
}