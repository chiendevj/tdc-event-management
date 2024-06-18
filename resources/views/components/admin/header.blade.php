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

    <div class="admin flex items-center justify-start gap-2 relative">
      @if (!Auth::check())
      <a href="{{ route('login') }}">
        <h1 class="text-lg font-bold text-white">Login</h1>
      </a>
      @else
      <div tabindex="0" class="profile flex items-center cursor-pointer">
        <img src="https://quizgecko.com/images/avatars/avatar-{{auth()->user()->id}}.webp" class="w-[50px] flex items-center justify-center h-[50px] m-[8px] rounded-full border-gray-500 ring-2" />
        <div>
          <h1 class="text-lg font-bold text-white">{{ auth()->user()->name }}</h1>
          <p class="text-sm text-gray-500">Admin</p>
        </div>
      </div>
      <div class="profile-option z-[99999] w-[220px] opacity-0 invisible p-5 rounded absolute top-[100%] right-0 border-[#eee] bg-primary shadow">
        <ul class="flex gap-3 flex-col">
          <li>
            <form action="{{ route('handle_logout') }}" method="POST">
              @csrf
              <button class="text-white flex gap-2 items-center">
                <i class="fa-light fa-arrow-up-left-from-circle text-[14px]"></i>
                Logout out
              </button>
            </form>
          </li>
        </ul>
      </div>
      @endif
    </div>
  </div>
</header>
