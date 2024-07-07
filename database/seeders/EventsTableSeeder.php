<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'id' => 1,
                'name' => 'Tuyển sinh Trường Cao đẳng Công nghệ Thủ Đức - TDC',
                'location' => 'Online',
                'event_photo' => '/storage/uploads/events/1719626393_banner1.jpg',
                'event_start' => '2024-07-03 13:00:00',
                'event_end' => '2024-07-03 16:00:00',
                'point' => 4,
                'registration_start' => '2024-06-29 01:57:00',
                'registration_end' => '2024-06-30 01:57:00',
                'registration_count' => 0,
                'content' => '<h3><a href="\&quot;https://www.facebook.com/tvtstdc?__cft__[0]=AZWviZaEemzayVeP8bz9xng3snpTgtuj1Mq6qhgYj70VWSy4IgumswMLTj9kM-UyQaVqkg1rj5NX0Fnv7BuIRYD2u3QEFLDMZmaYfWFYXYwWYarj1-JfwT38DLbtnwY-xwHngITFwIpX1ChO-mgalnJg9k_OUzDa4MFL03ClN7siMK4et4U41Ij7v7EjjW22jRsqiv382RO_0LJi2HOGFYcSyxQc3tIyfId9kSb-wD33w5OQbrdGumHPuMFX-lUFNr8&amp;__tn__=-UC%2CP-y-R\&quot;"><span class="text-huge"><strong><u>Tuyển sinh Trường Cao đẳng Công nghệ Thủ Đức - TDC</u></strong></span></a></h3><p><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t2c/1/16/1f631.png" alt="😱" width="16" height="16"> Bạn quan tâm đến lĩnh vực công nghệ thông tin?</p><p><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t73/1/16/1f979.png" alt="🥹" width="16" height="16"> Bạn băn khoăn không biết có nên chọn lĩnh vực CNTT để phát triển sự nghiệp? Sẽ có những thuận lợi - khó khăn nào trong ngành CNTT?</p><p><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t68/1/16/1fac2.png" alt="🫂" width="16" height="16"> Hãy cùng gặp nhau qua chia sẻ rất thật trong buổi livestream <img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t40/1/16/1f4a5.png" alt="💥" width="16" height="16">CHỌN CÔNG NGHỆ THÔNG TIN - VƯƠN MÌNH CÙNG KỶ NGUYÊN SỐ<img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t40/1/16/1f4a5.png" alt="💥" width="16" height="16"> vào <img src="https://static.xx.fbcdn.net/images/emoji.php/v9/tb0/1/16/1f3af.png" alt="🎯" width="16" height="16"> 20h00 Thứ 4, ngày 03/7/2024 nhé <img src="https://static.xx.fbcdn.net/images/emoji.php/v9/tea/1/16/1f970.png" alt="🥰" width="16" height="16"></p><figure class="image"><img style="aspect-ratio:960/540;" src="/storage/uploads/1719629501_banner1.jpg" width="960" height="540"></figure>',
                'registration_link' => 'http://127.0.0.1:8000/sukien/3/dangky',
                'status' => 'Đã diễn ra',
                'academic_period_id' => 12,
                'created_at' => '2024-06-29 02:19:45',
                'updated_at' => '2024-06-29 02:19:45',
            ],
            [
                'id' => 2,
                'name' => 'Chọn ngành dẫn đầu xu hướng',
                'location' => 'Online',
                'event_photo' => '/storage/uploads/events/1720326212_banner3.jpg',
                'event_start' => '2024-07-07 07:30:00',
                'event_end' => '2024-07-07 08:30:00',
                'point' => 4,
                'registration_start' => '2024-05-16 02:23:00',
                'registration_end' => '2024-05-17 02:23:00',
                'registration_count' => 0,
                'content' => '<p><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t2c/1/16/1f631.png" alt="😱" width="16" height="16"> Tada sự kiện hấp dẫn hông thể bỏ qua <img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t2/1/16/1f60d.png" alt="😍" width="16" height="16"></span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t4c/1/16/2753.png" alt="❓" width="16" height="16"> Bạn yêu thích nhóm ngành Công nghệ thông tin, Mạng máy tính, Thiết kế đồ họa?</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t4c/1/16/2753.png" alt="❓" width="16" height="16"> Bạn vẫn đang phân vân lựa chọn nhóm ngành CNTT để xây dựng sự nghiệp cho bản thân?</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t51/1/16/1f449.png" alt="👉" width="16" height="16"> Hãy theo dõi và tham gia ngay buổi livestream của FIT-TDC giới thiệu nhóm ngành CNTT với chủ đề "Chọn ngành thời thượng - Dẫn đầu xu hướng" vào lúc 7:00 tối thứ 7 ngày 2/7/2022 với sự tham gia của các khách mời:</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/tb/1/16/1f469_200d_1f9b0.png" alt="👩‍🦰" width="16" height="16"> Tiến sĩ Phan Thị Thể - Phó Trưởng Khoa CNTT</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t2c/1/16/1f468_200d_1f9b0.png" alt="👨‍🦰" width="16" height="16"> ThS. Nguyễn Huy Hoàng - Trưởng Bộ môn Công nghệ phần mềm</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t2c/1/16/1f468_200d_1f9b0.png" alt="👨‍🦰" width="16" height="16"> ThS. Cao Trần Thái Anh - Trưởng Bộ môn Mạng máy tính</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/td4/1/16/1f471_200d_2640.png" alt="👱‍♀️" width="16" height="16"> ThS. Bùi Thị Phương Thảo - Bí thư Đoàn Khoa CNTT</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/tba/1/16/1f4e3.png" alt="📣" width="16" height="16"> 7:00 tối thứ 7 ngày 2/7/2022, hãy nhớ theo dõi livestream để tìm hiểu nhóm ngành CNTT kỹ hơn cũng như nhận được các phần quà vô cùng giá trị <img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t2/1/16/1f60d.png" alt="😍" width="16" height="16"></span><br>&nbsp;</p>',
                'registration_link' => 'http://127.0.0.1:8000/sukien/2/dangky',
                'status' => 'Đã diễn ra',
                'academic_period_id' => 11,
                'created_at' => '2024-06-29 02:19:45',
                'updated_at' => '2024-06-29 02:19:45',
            ],
            [
                'id' => 3,
                'name' => 'Chiến dịch tình nguyện mùa hè Xanh 2024',
                'location' => 'Trường Cao Đẳng Công Nghệ Thủ Đức',
                'event_photo' => '/storage/uploads/events/1720326538_448460860_866587775492646_443778374086671771_n.jpg',
                'event_start' => '2024-07-07 07:30:00',
                'event_end' => '2024-07-07 08:30:00',
                'point' => 4,
                'registration_start' => '2024-05-16 02:23:00',
                'registration_end' => '2024-05-17 02:23:00',
                'registration_count' => 0,
                'content' => '<p><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);">Ve ve hè về, các Fit-TDC đã sắp thi xong rồi. Cùng TDC trải qua một mùa hè thật nhiều ý nghĩa với "MÙA HÈ XANH" nè. Khoa CNTT vẫn còn đang tuyển quân Mùa hè xanh nè. Các bạn nhanh nhanh đăng ký đi nè để trải nghiệm một mùa hè xanh 2024 thật đáng nhớ trong thanh xuân của mình cùng FIT-TDC nè!</span></p>',
                'registration_link' => 'http://127.0.0.1:8000/sukien/3/dangky',
                'status' => 'Đã diễn ra',
                'academic_period_id' => 11,
                'created_at' => '2024-06-29 02:19:45',
                'updated_at' => '2024-06-29 02:19:45',
            ],
        ];


        DB::table('events')->insert($events);
    }
}