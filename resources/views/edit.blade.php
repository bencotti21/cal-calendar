<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      メモ編集画面
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <x-input-error class="m-4" :messages="$errors->all()"></x-input-error>
        <div class="p-6 text-gray-900">
          <form method="POST" action="{{ route('memo.update', ['memo' => $memo]) }}">
            @csrf
            @method('PUT')
            <dev>
              <x-input-label>日付</x-input-label>
              <dev>
                <input type='number' name='year' value="{{ $year }}" class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
              </dev>
              <dev>年</dev>
              <dev>
                <select name='month' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                  @for ($i = 1; $i <= 12; $i++)
                    @if ($i == $month)
                      <option value="{{ $i }}" selected>{{ $i }}</option>
                    @else
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                  @endfor
                </select>
              </dev>
              <dev>月</dev>
              <dev>
                <select name='day' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                  @for ($i = 1; $i <= 31; $i++)
                    @if ($i == $day)
                      <option value="{{ $i }}" selected>{{ $i }}</option>
                    @else
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                  @endfor
                </select>
              </dev>
              <dev>日</dev>
            </dev>
            <dev>
              <x-input-label>メモ</x-input-label>
              <x-text-input type='text' name='memo' value='{{ $memo->memo }}'></x-text-input>
            </dev>
            <br>
            <dev>
              <x-input-label>数</x-input-label>
              <input type='number' name='number' value='{{ $memo->number }}' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
            </dev>
            <br>
            <dev>
              <x-input-label>タグ</x-input-label>
              <x-text-input type='text' name='tag' value='{{ $memo->tag }}'></x-text-input>
            </dev>
            <br>
            <dev>
              <x-primary-button>保存する</x-primary-button>
            </dev>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
