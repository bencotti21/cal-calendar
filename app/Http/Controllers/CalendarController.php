<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Calendar;

class CalendarController extends Controller
{
    //
    public function show(Request $request) {
        if ($request->year && $request->month) {
            $date = $request->year . "-" . $request->month;
        } else {
            $date = time();
        }
        $calendarObject = new Calendar($date);
        $calendar = $calendarObject->getCalendar();
        $year = $calendarObject->getYear();
        $month = $calendarObject->getMonth();
        return view('calendar', compact('calendar', 'year', 'month'));
    }
}
