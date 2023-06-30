<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemoRequest;
use App\Http\Requests\UpdateMemoRequest;
use App\Models\Memo;
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
        // 月末の日付
        $lastDay = Carbon::create($year, $month)->lastOfMonth()->day;

        return view('input', compact('year', 'month', 'day', 'lastDay'));
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemoRequest $request, Memo $memo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Memo $memo)
    {
        //
    }

    protected function validator(FormRequest $request)
    {
        return $request->validate([
            'year' => 'required|digits:4',
            'month' => 'required|integer|between:1,12',
            'day' => 'required|integer|min:1',
            'memo' => 'required|max:255',
            'number' => 'integer|min:-2147483648|max:2147483647',
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
}
