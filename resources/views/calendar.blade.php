<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      カレンダー画面
    </h2>
  </x-slot>

  <x-input-error class="m-4" :messages="$errors->all()"></x-input-error>
  <form method="GET" action="{{ route('calendar.index') }}">
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
    <x-primary-button>表示する</x-primary-button>
  </dev>
  <br>
  <div class="calendar">
    <table class="table">
      <thead>
        <tr>
          <th>日</th>
          <th>月</th>
          <th>火</th>
          <th>水</th>
          <th>木</th>
          <th>金</th>
          <th>土</th>
        </tr>
      </thead>
      <tbody>
        @foreach($calendar as $week)
          <tr>
            @foreach($week as $day)
              <td>
                <a href="{{ route('calendar.show', ['year' => $year, 'month' => $month, 'day' => $day]) }}">
                  <span>{{ $day }}</span>
                </a>
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-app-layout>