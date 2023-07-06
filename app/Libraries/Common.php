<?php

namespace App\Libraries;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class Common {
  public static function dayValidator($year, $month, $day) {
    // 日付が月末以前か検証するインスタンスを作成
    $lastDay = Carbon::create($year, $month)->lastOfMonth()->day;
    $input = ['day' => $day];
    $rule = ['day' => "integer|max:$lastDay"];
    $message = ['day' => '月末日以前の日付を入力してください。'];

    return Validator::make($input, $rule, $message);
  }
}