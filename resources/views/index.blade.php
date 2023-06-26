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
          @foreach ($memos as $memo)
            <span>{{ $memo->date }}</span>
            <span>{{ $memo->memo }}</span>
            <span>{{ $memo->number }}</span>
            <span>{{ $memo->tag }}</span>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
