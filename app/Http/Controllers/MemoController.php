<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemoRequest;
use App\Http\Requests\UpdateMemoRequest;
use App\Models\Memo;
use App\Libraries\Common;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $memos = Memo::all();
        return view('index', ['memos' => $memos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        if ($request->year && $request->month && $request->day) {
            $year = $request->year;
            $month = $request->month;
            $day = $request->day;
        } else {
            $year = date('Y');
            $month = date('n');
            $day = date('j');
        }

        return view('input', compact('year', 'month', 'day'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemoRequest $request)
    {
        //
        $inputs = $this->validator($request);

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

        $memo = new Memo();
        $memo->user_id = Auth::id();
        $memo->date = $inputs['year'] . "-" . $inputs['month'] . "-" . $inputs['day'];
        $memo->memo = $inputs['memo'];
        if ($request->number) {
            $memo->number = $inputs['number'];
        }
        $memo->tag = $inputs['tag'];
        $memo->save();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Memo $memo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Memo $memo)
    {
        //
        $date = explode("-", $memo->date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];

        return view('edit', compact('memo', 'year', 'month', 'day'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemoRequest $request, Memo $memo)
    {
        //
        $inputs = $this->validator($request);

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

        $memo->date = $inputs['year'] . "-" . $inputs['month'] . "-" . $inputs['day'];
        $memo->memo = $inputs['memo'];
        if ($request->number) {
            $memo->number = $inputs['number'];
        }
        $memo->tag = $inputs['tag'];
        $memo->save();

        return redirect()->route('memo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Memo $memo)
    {
        //
        $memo->delete();
        return redirect()->route('memo.index');
    }

    // 集計して表示する
    public function total(Request $request)
    {
        if ($request->minYear || $request->maxYear || $request->numberOrder || $request->tag) {
            $inputs = $this->totalValidator($request);

            // 集計開始の日付が月末以前か検証するインスタンスを作成
            $minDayValidator = Common::dayValidator($inputs['minYear'], $inputs['minMonth'], $inputs['minDay']);
            // 検証
            if ($minDayValidator->fails()) {
                return back()->withErrors($minDayValidator);
            }
            
            // 集計終了の日付が月末以前か検証するインスタンスを作成
            $maxDayValidator = Common::dayValidator($inputs['maxYear'], $inputs['maxMonth'], $inputs['maxDay']);
            // 検証
            if ($maxDayValidator->fails()) {
                return back()->withErrors($maxDayValidator);
            }
            
            $minDate = $inputs['minYear'] . "-" . $inputs['minMonth'] . "-" . $inputs['minDay'];
            $maxDate = $inputs['maxYear'] . "-" . $inputs['maxMonth'] . "-" . $inputs['maxDay'];

            // 集計終了日が集計開始日以降か検証するインスタンスを作成
            $input = ['maxDate' => $maxDate];
            $rule = ['maxDate' => "date|after_or_equal:$minDate"];
            $message = ['maxDate' => '集計終了日は集計開始日以降の日付を入力してください。'];
            $maxDateValidator = Validator::make($input, $rule, $message);
            // 検証
            if ($maxDateValidator->fails()) {
                return back()->withErrors($maxDateValidator);
            }

            $minYear = $inputs['minYear'];
            $minMonth = $inputs['minMonth'];
            $minDay = $inputs['minDay'];
            $maxYear = $inputs['maxYear'];
            $maxMonth = $inputs['maxMonth'];
            $maxDay = $inputs['maxDay'];
            $numberOrder = $request->numberOrder;
            $tag = $inputs['tag'];

            $memos = Memo::when($tag, function ($query) use ($tag) {$query->whereTag($tag);})
                    ->whereBetween('date',[$minDate, $maxDate])
                    ->select('memo','tag')
                    ->selectRaw('SUM(number) as total_number, MIN(date) as earliest_date, MAX(date) as latest_date')
                    ->groupBy('memo','tag')
                    ->when($numberOrder == 'desc', function ($query) {$query->orderBy('total_number', 'desc');}, function ($query) {$query->orderBy('total_number', 'asc');})
                    ->orderBy('earliest_date', 'asc')
                    ->orderBy('latest_date', 'asc')
                    ->get();

            return view('total', compact('memos', 'minYear', 'minMonth', 'minDay', 'maxYear', 'maxMonth', 'maxDay', 'numberOrder', 'tag'));
        }

        return view('total');
    }

    protected function validator(FormRequest $request)
    {
        return $request->validate([
            'year' => 'required|digits:4',
            'month' => 'required|integer|between:1,12',
            'day' => 'required|integer|min:1',
            'memo' => 'required|max:255',
            'number' => 'integer|min:-2147483648|max:2147483647|nullable',
            'tag' => 'max:255'
        ],
        [
            'year.required' => '年を入力してください。',
            'year.digits' => '年は4桁の整数で入力してください。',
            'month' => '月が不正な値です。',
            'day' => '日が不正な値です。',
            'memo.required' => 'メモを入力してください。',
            'memo.max' => 'メモは255文字以内にしてください。',
            'number.min' => '数は-2147483648以上にしてください。',
            'number.max' => '数は2147483647以下にしてください。',
            'tag.max' => 'タグは255文字以内にしてください。',
        ]);
    }

    protected function totalValidator(Request $request)
    {
        return $request->validate([
            'minYear' => 'required|digits:4',
            'minMonth' => 'required|integer|between:1,12',
            'minDay' => 'required|integer|min:1',
            'maxYear' => 'required|digits:4',
            'maxMonth' => 'required|integer|between:1,12',
            'maxDay' => 'required|integer|min:1',
            'tag' => 'max:255'
        ],
        [
            'minYear.required' => '集計開始年を入力してください。',
            'minYear.digits' => '集計開始年は4桁の整数で入力してください。',
            'minMonth' => '集計開始月が不正な値です。',
            'minDay' => '集計開始日が不正な値です。',
            'maxYear.required' => '集計終了年を入力してください。',
            'maxYear.digits' => '集計終了年は4桁の整数で入力してください。',
            'maxMonth' => '集計終了月が不正な値です。',
            'maxDay' => '集計終了日が不正な値です。',
            'tag.max' => 'タグは255文字以内にしてください。',
        ]);
    }
}
