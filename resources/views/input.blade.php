<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      メモ入力画面
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form method="POST" action="{{ route('memo.store') }}">
            @csrf
            <dev>
              <x-input-label>メモ</x-input-label>
              <x-text-input type='text' name='memo'></x-text-input>
            </dev>
            <br>
            <dev>
              <x-input-label>数</x-input-label>
              <input type='number' name='number' value=1 class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
            </dev>
            <br>
            <dev>
              <x-input-label>タグ</x-input-label>
              <x-text-input type='text' name='tag'></x-text-input>
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