<header class="shadow-md fixed top-0 left-0 right-0" id="navbar">
  <nav class="navbar flex justify-between items-center w-[92%] mx-auto">
      <div>
          <img class="md:w-44 w-32 py-3 cursor-pointer" src="{{ asset('assets/logo/logo_fit_tdc.png') }}" alt="Logo FIT">
      </div>
      <div class="nav-links duration-500 md:static absolute bg-white md:min-h-fit min-h-[60vh] right-0 top-0 md:w-auto w-full flex flex-col items-start px-5 md:hidden gap-5" id="sidebar">
          <span class="close-btn self-end mt-3 cursor-pointer text-2xl">&times;</span>
          <ul class="nav-menu flex md:flex-row flex-col md:items-center w-full mt-4 gap-[20px]">
              <li class="{{ Route::is('home') ? 'active' : '' }}">
                  <a class="hover:text-gray-500 font-semibold" href="{{ route('home')}}">Trang chủ</a>
              </li>
              <li class="{{ Route::is('calendar-event') ? 'active' : '' }}">
                <a class="hover:text-gray-500 font-semibold" href="{{ route('calendar-event') }}">Lịch sự kiện</a>
              </li>
              <li class="{{ Route::is('tra-cuu') ? 'active' : '' }}">
                <a class="hover:text-gray-500 font-semibold" href="{{ route('tra-cuu') }}">Tra cứu</a>
              </li>
              <li>
                <a class="hover:text-gray-500 font-semibold" href="{{ route('login') }}">Đăng nhập</a>
              </li>

          </ul>
      </div>
      <div class="flex items-center gap-6 md:hidden">
          <i onclick="onToggleMenu()" class="fa-solid fa-bars text-[14px] cursor-pointer"></i>
      </div>
  </nav>
</header>
<div id="overlay" onclick="onToggleMenu()"></div>
