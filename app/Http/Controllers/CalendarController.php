<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Libraries\Calendar;
use App\Models\Memo;
use Carbon\Carbon;

class CalendarController extends Controller
{
    //
    public function index(Request $request) {
        if ($request->year || $request->month) {
            $inputs = $this->indexValidator($request);
            $date = $inputs['year'] . "-" . $inputs['month'];
        } else {
            $date = time();
        }
        $calendarObject = new Calendar($date);
        $calendar = $calendarObject->getCalendar();
        $year = $calendarObject->getYear();
        $month = $calendarObject->getMonth();
        return view('calendar', compact('calendar', 'year', 'month'));
    }

    public function show(Request $request) {
        $inputs = $this->showValidator($request);

        // 日付が月末以前か検証するインスタンスを作成
        $lastDay = Carbon::create($inputs['year'], $inputs['month'])->lastOfMonth()->day;
        $input = ['day' => $inputs['day']];
        $rule = ['day' => "integer|max:$lastDay"];
        $message = ['day' => '月末日以前の日付を入力してください。'];
        $validator = Validator::make($input, $rule, $message);
        // 検証
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $year = $inputs['year'];
        $month = $inputs['month'];
        $day = $inputs['day'];
        $date = $year . "-" . $month . "-" . $day;
        $memos = Memo::where('date', '=', $date)->get();

        return view('date', compact('year', 'month', 'day', 'memos'));
    }

    protected function indexValidator(Request $request) {

        return $request->validate([
            'year' => 'required|digits:4',
            'month' => 'required|integer|between:1,12'
        ],[
            'year.required' => '年を入力してください。',
            'year.digits' => '年は4桁の整数で入力してください。',
            'month' => '月が不正な値です。'
        ]);
    }

    protected function showValidator(Request $request) {

        return $request->validate([
            'year' => 'required|digits:4',
            'month' => 'required|integer|between:1,12',
            'day' => 'required|integer|min:1',
        ],[
            'year.required' => '年を入力してください。',
            'year.digits' => '年は4桁の整数で入力してください。',
            'month' => '月が不正な値です。',
            'day' => '日が不正な値です。',
        ]);
    }
}
