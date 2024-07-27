<header class="bg-[var(--dark-bg)]">
    {{-- Menu mobile --}}
    <div class="fixed menu_mobile w-full top-0 left-0 bottom-0 bg-[var(--dark-bg)] text-white z-10 p-8 flex flex-col items-center justify-center">
        <div class="w-full h-auto flex flex-col items-center justify-center">
            <img src="https://quizgecko.com/images/avatars/avatar-{{ auth()->user()->id }}.webp" class="w-[50px] flex items-center justify-center h-[50px] m-[8px] rounded-full border-gray-500 ring-2" />
            <div class="text-center">
                <h1 class="text-lg font-bold text-white">{{ auth()->user()->name }}</h1>
                <p class="text-sm text-gray-500">
                    @role('super-admin')
                    Super Admin
                    @else
                    Admin
                    @endrole
                </p>
            </div>
        </div>
        <div class="h-full flex items-start mt-10 justify-center">
            <ul class="rounded-tr-lg rounded-br-lg gap-4 flex flex-col text-center text-white bg-[var(--dark-bg)]">
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('events.index') ? 'border-[var(--nav-hover)]' : '' }} transition-all duration-100 ease-in">
                    <a href="{{ route('events.index') }}">Sự kiện</a>
                </li>
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('students.index') ? 'border-[var(--nav-hover)]' : '' }} transition-all duration-100 ease-in">
                    <a href="{{ route('students.index') }}">Sinh viên</a>
                </li>
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('statisticals.index') ? 'border-[var(--nav-hover)]' : '' }} transition-all duration-100 ease-in">
                    <a href="{{ route('statisticals.index') }}">Thống kê</a>
                </li>
                @role('super-admin')
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('accounts.index') ? 'border-[var(--nav-hover)]' : '' }}  transition-all duration-100 ease-in">
                    <a href="{{ route('accounts.index') }}">Tài khoản</a>
                </li>
                @endrole
                <li class="border-b-2 border-b-transparent w-fit hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                    <a href="/">Trở về trang người dùng</a>
                </li>
                <li class="border-b-2 border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                    <form action="{{ route('handle_logout') }}" method="POST">
                        @csrf
                        <button>
                            Đăng xuất
                            <i class="fa-light fa-right-from-bracket"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <button class="btn_close_menu_mobile absolute top-4 right-4 hover:scale-110 duration-150 ease-in transition-al">
            <i class="fa-regular fa-times text-white text-2xl hover:text-red-500"></i>
        </button>
    </div>
    <div class="container mx-auto z-50 w-full px-8 py-4 flex items-center justify-between">
        <h1 class="text-lg text-white font-semibold">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/logo/fit_circle.png') }}" alt="FIT TDC" class="w-[50px] h-[50px] rounded-full">
            </a>
        </h1>
        {{-- Navbar start --}}
        <div class="h-full flex items-center justify-center">
            <ul class="rounded-tr-lg rounded-br-lg gap-4 hidden lg:flex sm:hidden text-white bg-[var(--dark-bg)]">
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('dashboard') ? 'border-[var(--nav-hover)]' : '' }} transition-all duration-100 ease-in">
                    <a href="{{ route('dashboard') }}">Trang chủ</a>
                </li>
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('events.index') ? 'border-[var(--nav-hover)]' : '' }} transition-all duration-100 ease-in">
                    <a href="{{ route('events.index') }}">Sự kiện</a>
                </li>
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('students.index') ? 'border-[var(--nav-hover)]' : '' }} transition-all duration-100 ease-in">
                    <a href="{{ route('students.index') }}">Sinh viên</a>
                </li>
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('statisticals.index') ? 'border-[var(--nav-hover)]' : '' }} transition-all duration-100 ease-in">
                    <a href="{{ route('statisticals.index') }}">Thống kê</a>
                </li>
                @role('super-admin')
                <li class="border-b-2 border-[var(--dark-bg)] hover:border-[var(--nav-hover)] {{ Route::is('accounts.index') ? 'border-[var(--nav-hover)]' : '' }} transition-all duration-100 ease-in">
                    <a href="{{ route('accounts.index') }}">Tài khoản</a>
                </li>
                @endrole
                <li class="border-b-2 has_child border-b-[var(--dark-bg)] hover:border-[var(--nav-hover)] transition-all duration-100 ease-in cursor-pointer relative">
                    Xem thêm <i class="fa-regular fa-chevron-down text-sm "></i>
                    <ul class="absolute child bg-white text-black top-[40px] shadow-lg rounded-sm p-4 min-w-[300px] flex flex-col gap-2">
                        <li class="border-b-2 border-b-white w-fit hover:border-[var(--nav-hover)] transition-all duration-100 ease-in">
                            <a href="/">Trở về trang người dùng</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        {{-- Navbar end --}}

        <div class="admin flex items-center justify-start gap-2 relative">
            @if (!Auth::check())
            <a href="{{ route('login') }}">
                <h1 class="text-lg font-bold text-white">Đăng nhập</h1>
            </a>
            @else
            <div tabindex="0" class="profile flex justify-center items-center cursor-pointer">
                <img src="https://quizgecko.com/images/avatars/avatar-{{ auth()->user()->id }}.webp" class="hidden w-[50px] lg:flex items-center justify-center h-[50px] m-[8px] rounded-full border-gray-500 ring-2" />
                <div class="hidden lg:block">
                    <h1 class="text-lg font-bold text-white">{{ auth()->user()->name }}</h1>
                    <p class="text-sm text-gray-500">
                        @role('super-admin')
                        Super Admin
                        @else
                        Admin
                        @endrole
                    </p>
                </div>
                <button class="menu-icon lg:ms-4 btn_open_menu_mobile lg:hidden flex items-center justify-center">
                    <i class="fa-regular fa-bars text-white text-2xl"></i>
                </button>
            </div>
            <div class="profile-option hidden z-[99999] w-[220px] opacity-0 invisible p-5 rounded absolute top-[100%] bg-white lg:flex items-center justify-center right-0 border-[#eee] bg-primary shadow">
                <ul class="flex gap-3 flex-col">
                    <li>
                        <form action="{{ route('handle_logout') }}" method="POST">
                            @csrf
                            <button class="flex gap-2 justify-center items-center text-black hover:text-blue-500">
                                Đăng xuất
                                <i class="fa-light fa-right-from-bracket"></i>
                            </button>
                        </form>
                    </li>
                    <li>
                        <button class="flex gap-2 justify-center items-center text-black hover:text-blue-500" id="change_password">
                            Đổi mật khẩu
                        </button>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>

    <script>
        const btn_open_menu_mobile = document.querySelector('.btn_open_menu_mobile');
        const btn_close_menu_mobile = document.querySelector('.btn_close_menu_mobile');
        const menu_mobile = document.querySelector('.menu_mobile');

        btn_open_menu_mobile.addEventListener('click', () => {
            menu_mobile.classList.add('active');
        });

        btn_close_menu_mobile.addEventListener('click', () => {
            menu_mobile.classList.remove('active');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const changePasswordBtn = document.getElementById('change_password');
            const changePasswordModal = document.getElementById('changePasswordModal');
            const closeChangePasswordModalBtn = document.getElementById('closeChangePasswordModal');

            // Show modal when "Đổi mật khẩu" button is clicked
            changePasswordBtn.addEventListener('click', function() {
                changePasswordModal.classList.remove('hidden');
            });

            // Close modal when "Hủy" button is clicked
            closeChangePasswordModalBtn.addEventListener('click', function() {
                changePasswordModal.classList.add('hidden');
            });

            // Optionally close the modal when clicking outside of it
            window.addEventListener('click', function(event) {
                if (event.target === changePasswordModal) {
                    changePasswordModal.classList.add('hidden');
                }
            });
        });
    </script>
</header>
<!-- Change Password Modal -->
<div id="changePasswordModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-lg font-bold mb-4">Đổi mật khẩu</h2>
        <form action="{{ route('change_password') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="current_password" class="block text-[14px] font-medium text-blue-900">Mật khẩu hiện tại <span class="text-red-500">*</span></label>
                <input type="password" name="current_password" id="current_password" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập mật khẩu hiện tại" required>
                @error('current_password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="new_password" class="block text-[14px] font-medium text-blue-900">Mật khẩu mới <span class="text-red-500">*</span></label>
                <input type="password" name="new_password" id="new_password" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập mật khẩu mới" required>

            </div>
            <div class="flex justify-end gap-2">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Đổi mật khẩu</button>
                <button type="button" id="closeChangePasswordModal" class="ml-4 bg-gray-300 text-gray-700 px-4 py-2 rounded-md">Hủy</button>
            </div>
        </form>
    </div>
</div>