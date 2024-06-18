@extends('layouts.admin')

@section('title', 'Create new Events')

@section('content')
    <div class="container mx-auto mt-[40px]">
     <div class="flex items-center justify-between mb-[20px]">
      <h3 class="uppercase block p-2 font-semibold rounded-sm text-white bg-[var(--dark-bg)] w-fit">
        Danh sách các sự kiện</h3>
        <div class="relative border flex items-center justify-start p-2">
          <input type="text" placeholder="Tìm kiếm sự kiện" class=" outline-none rounded-sm min-w-[400px]">

          <div class="text-gray-400">
            <i class="fa-light fa-magnifying-glass"></i>
          </div>
        </div>
     </div>
     <div class="w-full flex items-center justify-end">
      <a href="{{ route('events.create') }}" class="block p-2 bg-[var(--dark-bg)] text-white rounded-sm ml-auto w-fit">Tạo sự kiện mới</a>
     </div>
    </div>
@endsection
