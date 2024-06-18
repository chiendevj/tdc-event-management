<header class="bg-[var(--dark-bg)]">
  <div class="container mx-auto w-full px-8 py-4 flex items-center justify-between">
    <h1 class="text-lg text-white font-semibold">
      <a href="{{ route('dashboard') }}">
        Dashboard
      </a>
    </h1>
    {{-- <div class="logo">
      <img src="{{ asset('assets/logo/logo_fit_tdc.png') }}" class="h-[80px]" alt="">
    </div> --}}

    {{-- Navbar start --}}
    <div class="h-full flex items-center justify-center">
      <ul class="flex rounded-tr-lg rounded-br-lg gap-4 text-white bg-[var(--dark-bg)]">
          <li class="border-b-2 border-b-[var(--dark-bg)] hover:border-purple-500 transition-all duration-100 ease-in"><a href="">Tài khoản quản lý</a></li>
          <li class="border-b-2 border-b-[var(--dark-bg)] hover:border-purple-500 transition-all duration-100 ease-in"><a href="">Sinh viên</a></li>
          <li class="border-b-2 border-b-[var(--dark-bg)] hover:border-purple-500 transition-all duration-100 ease-in"><a href="">Sự kiện</a></li>
          <li class="border-b-2 has_child border-b-[var(--dark-bg)] hover:border-purple-500 transition-all duration-100 ease-in cursor-pointer relative">
            Xem thêm <i class="fa-regular fa-chevron-down text-sm "></i>
            <ul class="absolute child bg-white text-black top-[40px] shadow-lg rounded-sm p-4 min-w-[300px] flex flex-col gap-2">
              <li class="border-b-2 border-b-white w-fit hover:border-purple-500 transition-all duration-100 ease-in"><a href="">Somthing</a></li>
              <li class="border-b-2 border-b-white w-fit hover:border-purple-500 transition-all duration-100 ease-in"><a href="">Other</a></li>
            </ul>
          </li>
      </ul>
  </div>

  {{-- Navbar end --}}

    <div class="admin flex items-center justify-start gap-2">
      <div class="w-[42px] flex items-center justify-center h-[42px] p-[8px] rounded-full text-white bg-purple-800">
        D
      </div>
      <div class="">
        <h1 class="text-lg font-bold text-white">Datto</h1>
        <p class="text-sm text-gray-500">Admin</p>
      </div>
    </div>
  </div>
</header>