<footer class="bg-[var(--dark-bg)] text-white rounded-tl-3xl rounded-tr-3xl footer">
    <div class="container mx-auto py-8 px-4">
        <div class="flex flex-wrap">
            <!-- Logo và Mô tả -->
            <div class="w-full md:w-1/3 mb-6">
                <h1 class="text-lg text-white font-semibold">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/logo/fit_circle.png') }}" alt="FIT TDC" class="w-[50px] h-[50px] rounded-full">
                    </a>
                </h1>
                <p class="mt-2"><span class="font-semibold">KHOA CÔNG NGHỆ THÔNG TIN</span><br />Trường Cao Đẳng Công Nghệ Thủ Đức</p>
                <div class="flex justify-start mt-4">
                    <a href="#" class="text-white hover:text-blue-600 mr-4"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white hover:text-red-600 mr-4"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-white hover:text-blue-700 mr-4"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <!-- Điều hướng -->
            <div class="w-full md:w-1/3 mb-6 text-center">
                <h2 class="text-xl font-bold">Điều hướng</h2>
                <ul class="mt-2">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-yellow-300">Trang chủ</a></li>
                    <li><a href="{{ route('events.index') }}" class="hover:text-yellow-300">Sự kiện</a></li>
                    <li><a href="{{ route('statisticals.index') }}" class="hover:text-yellow-300">Thống kê</a></li>
                </ul>
            </div>
            <!-- Liên hệ -->
            <div class="w-full md:w-1/3 mb-6 text-right">
                <h2 class="text-xl font-bold">Liên hệ</h2>
                <ul class="mt-2">
                    <li><span class="font-bold">Địa chỉ: </span>53 Võ Văn Ngân, Phường Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh</li>
                    <li><span class="font-bold">Điện thoại: </span>(028) 22 158 642; Nội bộ: 309</li>
                    <li><span class="font-bold">Email:</span> eventfit@tdc.edu.vn</li>
                </ul>
            </div>
            <div class="w-full mt-4">
                <iframe class="w-full h-64 border-4 rounded-lg" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.4785853764834!2d106.75536847465649!3d10.851157389302198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527bd532d45d9%3A0x6b46595d312dcffe!2zNTMgxJAuIFbDtSBWxINuIE5nw6JuLCBMaW5oIENoaeG7g3UsIFRo4bunIMSQ4bupYywgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1718988275164!5m2!1svi!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div class="border-t border-gray-100 mt-6 pt-6 text-center">
            <p>&copy; 2024 Khoa Công nghệ thông tin | Cao đẳng Công nghệ Thủ Đức | FIT - TDC All Rights Reserved.</p>
        </div>
    </div>
</footer>