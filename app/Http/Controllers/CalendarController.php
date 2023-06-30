<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Calendar;

class CalendarController extends Controller
{
    //
    public function index(Request $request) {
        if ($request->year || $request->month) {
            $inputs = $this->validator($request);
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

    protected function validator(Request $request) {

        return $request->validate([
            'year' => 'required|digits:4',
            'month' => 'required|integer|between:1,12'
        ],[
            'year.required' => '年を入力してください。',
            'year.digits' => '年は4桁の整数で入力してください。',
            'month.required' => '月が不正な値です。',
            'month.integer' => '月が不正な値です。',
            'month.between' => '月が不正な値です。'
        ]);
    }
}
