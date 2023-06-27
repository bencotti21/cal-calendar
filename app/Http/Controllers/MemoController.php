<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemoRequest;
use App\Http\Requests\UpdateMemoRequest;
use App\Models\Memo;
use Illuminate\Support\Facades\Auth;

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
    public function create()
    {
        //
        return view('input');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemoRequest $request)
    {
        //
        $memo = new Memo();
        $memo->user_id = Auth::id();
        // $memo->date = $request->date;
        $memo->date = date('Y-m-d'); //検証用
        $memo->memo = $request->memo;
        $memo->number = $request->number;
        $memo->tag = $request->tag;
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
}
