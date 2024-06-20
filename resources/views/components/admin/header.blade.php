<header class="bg-[var(--dark-bg)]">
    {{-- Menu mobile --}}
    <div
        class="fixed menu_mobile w-full top-0 left-0 bottom-0 bg-[var(--dark-bg)] text-white z-10 p-8 flex flex-col items-center justify-center">
        <div class="w-full h-auto flex flex-col items-center justify-center">
            <img src="https://quizgecko.com/images/avatars/avatar-{{ auth()->user()->id }}.webp"
                class="w-[50px] flex items-center justify-center h-[50px] m-[8px] rounded-full border-gray-500 ring-2" />
            <div class="text-center">
                <h1 class="text-lg font-bold text-white">{{ auth()->user()->name }}</h1>
                <p class="text-sm text-gray-500">Admin</p>
            </div>
        </div>
        <div class="h-full flex items-start mt-10 justify-center">
            <ul class="rounded-tr-lg rounded-br-lg gap-4 flex flex-col text-center text-white bg-[var(--dark-bg)]">
                <li
                    class="border-b-2 border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                    <a href="">Tài khoản quản lý</a>
                </li>
                <li
                    class="border-b-2 border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                    <a href="">Sinh viên</a>
                </li>
                <li
                    class="border-b-2 border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                    <a href="{{ route('events.index') }}">Sự kiện</a>
                </li>
            </ul>
        </div>

        <button class="btn_close_menu_mobile absolute top-4 right-4 hover:scale-110 duration-150 ease-in transition-al">
            <i class="fa-regular fa-times text-white text-2xl hover:text-red-500"></i>
        </button>
    </div>
    <div class="container mx-auto w-full px-8 py-4 flex items-center justify-between">
        <h1 class="text-lg text-white font-semibold">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/logo/fit_circle.png') }}" alt="FIT TDC" class="w-[50px] h-[50px] rounded-full">
            </a>
        </h1>
        {{-- <div class="logo">
          <img src="{{ asset('assets/logo/logo_fit_tdc.png') }}" class="h-[80px]" alt="">
        </div> --}}
        {{-- Navbar start --}}
        <div class="h-full flex items-center justify-center">
            <ul class="rounded-tr-lg rounded-br-lg gap-4 hidden lg:flex sm:hidden text-white bg-[var(--dark-bg)]">
                <li
                    class="border-b-2 border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                    <a href="">Tài khoản</a>
                </li>
                <li
                    class="border-b-2 border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                    <a href="">Sinh viên</a>
                </li>
                <li
                    class="border-b-2 border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                    <a href="{{ route('events.index') }}">Sự kiện</a>
                </li>
                <li
                    class="border-b-2 has_child border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in cursor-pointer relative">
                    Xem thêm <i class="fa-regular fa-chevron-down text-sm "></i>
                    <ul
                        class="absolute child bg-white text-black top-[40px] shadow-lg rounded-sm p-4 min-w-[300px] flex flex-col gap-2">
                        <li
                            class="border-b-2 border-b-white w-fit hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                            <a href="">Thống kê</a>
                        </li>
                        <li
                            class="border-b-2 border-b-white w-fit hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                            <a href="">Other</a>
                        </li>
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
                <div tabindex="0" class="profile flex justify-center items-center cursor-pointer">
                    <img src="https://quizgecko.com/images/avatars/avatar-{{ auth()->user()->id }}.webp"
                        class="hidden w-[50px] lg:flex items-center justify-center h-[50px] m-[8px] rounded-full border-gray-500 ring-2" />
                    <div class="hidden lg:block">
                        <h1 class="text-lg font-bold text-white">{{ auth()->user()->name }}</h1>
                        <p class="text-sm text-gray-500">Admin</p>
                    </div>
                    <button class="menu-icon ms-4 btn_open_menu_mobile lg:hidden flex items-center justify-center">
                        <i class="fa-regular fa-bars text-white text-2xl"></i>
                    </button>
                </div>
                <div
                    class="profile-option z-[99999] w-[220px] opacity-0 invisible p-5 rounded absolute top-[100%] bg-white flex items-center justify-center right-0 border-[#eee] bg-primary shadow">
                    <ul class="flex gap-3 flex-col">
                        <li>
                            <form action="{{ route('handle_logout') }}" method="POST">
                                @csrf
                                <button class="flex gap-2 justify-center items-center text-black">
                                  Logout out
                                  <i class="fa-light fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <script>
      const btn_open_menu_mobile = document.querySelector('.btn_open_menu_mobile');
      const btn_close_menu_mobile = document.querySelector('.btn_close_menu_mobile');

      btn_open_menu_mobile.addEventListener('click', () => {
        document.querySelector('.menu_mobile').classList.add('active');
      });

      btn_close_menu_mobile.addEventListener('click', () => {
        document.querySelector('.menu_mobile').classList.remove('active');
      });
    </script>
</header>
