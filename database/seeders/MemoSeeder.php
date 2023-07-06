<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('memos')->insert([
            [
                'user_id' => '3',
                'date' => '2023-07-01',
                'memo' => 'ラーメン',
                'number' => '1',
                'tag' => '夕食',
            ],
            [
                'user_id' => '3',
                'date' => '2023-07-03',
                'memo' => 'ラーメン',
                'number' => '2',
                'tag' => '夕食',
            ],
            [
                'user_id' => '3',
                'date' => '2023-07-05',
                'memo' => 'ラーメン',
                'number' => '3',
                'tag' => '夕食',
            ],
            [
                'user_id' => '3',
                'date' => '2023-07-02',
                'memo' => 'ラーメン',
                'number' => '4',
                'tag' => '昼食',
            ],
            [
                'user_id' => '3',
                'date' => '2023-07-04',
                'memo' => 'ラーメン',
                'number' => '5',
                'tag' => '',
            ],
            [
                'user_id' => '3',
                'date' => '2023-07-06',
                'memo' => 'ラーメン',
                'number' => '-1',
                'tag' => '夕食',
            ],
            [
                'user_id' => '3',
                'date' => '2023-07-05',
                'memo' => '餃子',
                'number' => '1',
                'tag' => '夕食',
            ],
        ]);
    }
}
