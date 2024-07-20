<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $notifys = [
            [
                'id' => 1,
                'title' => 'Thông báo về việc hủy sự kiện',
                'content' => "<p>Kính gửi quý thầy cô và các em học sinh,</p>
                            <p>Chúng tôi rất tiếc phải thông báo rằng sự kiện <strong>Thiết kế đồ họa | Tư duy thiết kế về số</strong> dự kiến diễn ra
                                vào ngày <strong>2024-07-20</strong> tại <strong>Trường Cao Đẳng Công Nghệ Thủ Đức</strong> sẽ bị hủy bỏ do
                                <strong>một số lý do ngoài ý muốn.</strong>.</p>
                            <p>Chúng tôi xin lỗi về bất kỳ sự bất tiện nào có thể gây ra và rất biết ơn sự thông cảm của quý thầy cô và
                                các em học sinh trong tình huống này. Chúng tôi đang làm việc để lên lịch lại sự kiện và sẽ thông báo
                                đến mọi người sớm nhất có thể.</p>
                            <p>Nếu cần thêm thông tin hoặc có bất kỳ câu hỏi nào, xin vui lòng liên hệ với chúng tôi qua <strong>email:
                            eventfit@tdc.edu.vn</strong> hoặc số điện thoại: <strong>(028) 22 158 642, Nội bộ: 309</strong>.</p>
                            <p>Một lần nữa, chúng tôi xin chân thành cảm ơn quý thầy cô và các em học sinh đã hiểu và thông cảm.</p>
                            <p>Trân trọng,<br>
                                <strong>Ban Tổ Chức Sự kiện Khoa Công Nghệ Thông Tin, Trường Cao Đằng Công Nghệ Thủ Đức</strong>
                            </p>",
                'expires_at' => '2024-07-30 15:10:00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        DB::table('notifications')->insert($notifys);
    }
}
