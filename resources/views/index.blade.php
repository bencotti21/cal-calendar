<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      メモ一覧画面
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <table class="table">
            <thead>
              <tr>
                <th>日付</th>
                <th>メモ</th>
                <th>数</th>
                <th>タグ</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($memos as $memo)
                <tr>
                  <td><span>{{ $memo->date }}</span></td>
                  <td><span>{{ $memo->memo }}</span></td>
                  <td><span>{{ $memo->number }}</span></td>
                  <td><span>{{ $memo->tag }}</span></td>
                  <td><a href="{{ route('memo.edit', ['memo' => $memo]) }}">[編集]</a></td>
                  <td>
                    <form method="POST" action="{{ route('memo.destroy', ['memo' => $memo]) }}">
                      @csrf
                      @method('DELETE')
                      <x-primary-button onclick="return confirm('メモを削除しますか？')">削除</x-primary-button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
