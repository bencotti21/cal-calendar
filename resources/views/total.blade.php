<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      メモ集計画面
    </h2>
  </x-slot>

  <x-input-error class="m-4" :messages="$errors->all()"></x-input-error>
  <form method="GET" action="{{ route('memo.total') }}">
    <x-input-label>集計開始日</x-input-label>
    <dev>
      @isset($minYear)
        <input type='number' name='minYear' value="{{ $minYear }}" class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
      @else
        <input type='number' name='minYear' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
      @endisset
    </dev>
    <dev>年</dev>
    <dev>
      <select name='minMonth' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
        @for ($i = 1; $i <= 12; $i++)
          @if (isset($minMonth) && $i == $minMonth)
            <option value="{{ $i }}" selected>{{ $i }}</option>
          @else
            <option value="{{ $i }}">{{ $i }}</option>
          @endif
        @endfor
      </select>
    </dev>
    <dev>月</dev>
    <dev>
      <select name='minDay' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
        @for ($i = 1; $i <= 31; $i++)
          @if (isset($minDay) && $i == $minDay)
            <option value="{{ $i }}" selected>{{ $i }}</option>
          @else
            <option value="{{ $i }}">{{ $i }}</option>
          @endif
        @endfor
      </select>
    </dev>
    <dev>日</dev>
    <x-input-label>集計終了日</x-input-label>
    <dev>
      @isset($maxYear)
        <input type='number' name='maxYear' value="{{ $maxYear }}" class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
      @else
        <input type='number' name='maxYear' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
      @endisset
    </dev>
    <dev>年</dev>
    <dev>
      <select name='maxMonth' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
        @for ($i = 1; $i <= 12; $i++)
          @if (isset($maxMonth) && $i == $maxMonth)
            <option value="{{ $i }}" selected>{{ $i }}</option>
          @else
            <option value="{{ $i }}">{{ $i }}</option>
          @endif
        @endfor
      </select>
    </dev>
    <dev>月</dev>
    <dev>
      <select name='maxDay' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
        @for ($i = 1; $i <= 31; $i++)
          @if (isset($maxDay) && $i == $maxDay)
            <option value="{{ $i }}" selected>{{ $i }}</option>
          @else
            <option value="{{ $i }}">{{ $i }}</option>
          @endif
        @endfor
      </select>
    </dev>
    <dev>日</dev>
    <dev>
      <x-input-label>並び順</x-input-label>
      @isset($numberOrder)
        @if ($numberOrder == 'desc')
          <input type="radio" name="numberOrder" value="asc">合計数の昇順
          <input type="radio" name="numberOrder" value="desc" checked>合計数の降順
        @else
          <input type="radio" name="numberOrder" value="asc" checked>合計数の昇順
          <input type="radio" name="numberOrder" value="desc">合計数の降順
        @endif
      @else
        <input type="radio" name="numberOrder" value="asc">合計数の昇順
        <input type="radio" name="numberOrder" value="desc">合計数の降順
      @endisset
    </dev>
    <dev>
      <x-input-label>タグによる絞り込み</x-input-label>
      @isset($tag)
        <x-text-input type='text' name='tag' value="{{ $tag }}"></x-text-input>
      @else
        <x-text-input type='text' name='tag'></x-text-input>
      @endisset
    </dev>
    <br>
    <dev>
      <x-primary-button>集計する</x-primary-button>
    </dev>
  </form>

  @isset ($memos)
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <table class="table">
              <thead>
                <tr>
                  <th>日付</th>
                  <th>日付</th>
                  <th>メモ</th>
                  <th>数</th>
                  <th>タグ</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($memos as $memo)
                  <tr>
                    <td><span>{{ $memo->earliest_date }}</span></td>
                    <td><span>{{ $memo->latest_date }}</span></td>
                    <td><span>{{ $memo->memo }}</span></td>
                    <td><span>{{ $memo->total_number }}</span></td>
                    <td><span>{{ $memo->tag }}</span></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  @endisset
</x-app-layout>
