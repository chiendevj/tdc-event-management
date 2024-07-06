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
                'name' => 'WORKSHOP Hiểu về giấy',
                'location' => 'Hội trường B',
                'event_photo' => '/storage/uploads/events/1719627271_banner2.jpg',
                'event_start' => '2024-06-06 02:14:00',
                'event_end' => '2024-06-07 02:14:00',
                'point' => 4,
                'registration_start' => '2024-06-02 02:14:00',
                'registration_end' => '2024-06-04 02:14:00',
                'registration_count' => 0,
                'content' => '<p><span class=\"text-huge\"><strong>WORKSHOP-Hiểu về giấy- 8hAM-Ngày 6.6.2024</strong></span></p> ...',
                'registration_link' => 'http://127.0.0.1:8000/sukien/1/dangky',
                'status' => 'Đã diễn ra',
                'academic_period_id' => 11,
                'created_at' => '2024-06-29 02:14:31',
                'updated_at' => '2024-06-29 02:14:31',
            ],
            [
                'id' => 2,
                'name' => 'Workshop xây dựng thương hiệu cá nhân trong thời đại chuyển đổi số',
                'location' => 'Hội trường D',
                'event_photo' => '/storage/uploads/events/1719627585_banner3.jpg',
                'event_start' => '2024-05-18 02:18:00',
                'event_end' => '2024-05-18 03:17:00',
                'point' => 4,
                'registration_start' => '2024-05-16 02:18:00',
                'registration_end' => '2024-05-17 02:18:00',
                'registration_count' => 0,
                'content' => '<p><span class=\"text-huge\"><strong>Workshop xây dựng thương hiệu cá nhân trong thời đại chuyển đổi số</strong></span></p> ...',
                'registration_link' => 'http://127.0.0.1:8000/sukien/2/dangky',
                'status' => 'Đã diễn ra',
                'academic_period_id' => 11,
                'created_at' => '2024-06-29 02:19:45',
                'updated_at' => '2024-06-29 02:19:45',
            ],
            [
                'id' => 3,
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
                'id' => 4,
                'name' => 'Cuộc thi fit web dev challenges',
                'location' => 'Phòng B002B',
                'event_photo' => '/storage/uploads/events/1719627830_banner4.jpg',
                'event_start' => '2024-05-18 07:30:00',
                'event_end' => '2024-05-18 08:30:00',
                'point' => 4,
                'registration_start' => '2024-05-16 02:23:00',
                'registration_end' => '2024-05-17 02:23:00',
                'registration_count' => 0,
                'content' => '<p><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t83/1/16/1f60e.png" alt="😎" width="16" height="16"> Chắc không cần phải nói nhiều, đội tuyển Web của FIT-TDC đã nhiều năm đạt thành tích cao trong các hội thi cấp thành phố.</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t58/1/16/1f929.png" alt="🤩" width="16" height="16"> Bạn muốn được thử sức ở cuộc thi web cấp trường trước khi chiến đấu ở các cấp cao hơn?</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/tea/1/16/1f970.png" alt="🥰" width="16" height="16"> Hãy tham gia ngay cuộc thi "FIT Web Dev Challenges 2024" để có cơ hội nhận được các giải thưởng<img src="https://static.xx.fbcdn.net/images/emoji.php/v9/tbe/1/16/1f3c6.png" alt="🏆" width="16" height="16"> vô cùng giá trị :</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t94/1/16/1f947.png" alt="🥇" width="16" height="16"> 01 Giải nhất: ​1.000.000Đ/giải + Giấy khen Hiệu trưởng.</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t15/1/16/1f948.png" alt="🥈" width="16" height="16"> 01 Giải nhì: ​700.000Đ/giải + Giấy khen Hiệu trưởng.</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t96/1/16/1f949.png" alt="🥉" width="16" height="16"> 01 Giải ba: ​500.000Đ/giải + Giấy khen Hiệu trưởng.</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);"><img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t3d/1/16/1f3c5.png" alt="🏅" width="16" height="16"> 01 Giải KK: ​200.000Đ/giải + Giấy khen Hiệu trưởng.</span><br><span style="background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);">Đồng thời được tham gia vào đội tuyển web cấp thành phố cực ngầu của FIT-TDC <img src="https://static.xx.fbcdn.net/images/emoji.php/v9/t83/1/16/1f60e.png" alt="😎" width="16" height="16"></span><br>&nbsp;</p>',
                'registration_link' => 'http://127.0.0.1:8000/sukien/4/dangky',
                'status' => 'Đã diễn ra',
                'academic_period_id' => 11,
                'created_at' => '2024-06-29 02:19:45',
                'updated_at' => '2024-06-29 02:19:45',
            ],
        ];


        DB::table('events')->insert($events);
    }
}