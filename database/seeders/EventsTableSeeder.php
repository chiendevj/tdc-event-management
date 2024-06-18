<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'name' => 'WORKSHOP Paper Talk - Hiểu Về Giấy',
                'event_photo' => 'banner1.jpg',
                'location' => 'Hội trường B, 53 Võ Văn Ngân, Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh, Trường Cao Đẳng Công Nghệ Thủ Đức',
                'event_start' => Carbon::create('2024', '06', '01', '08', '00', '00'),
                'event_end' => Carbon::create('2024', '06', '03', '12', '00', '00'),
                'point' => 5,
                'registration_start' => Carbon::create('2024', '05', '20', '00', '00', '00'),
                'registration_end' => Carbon::create('2024', '05', '30', '23', '59', '59'),
                'registration_count' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'WORKSHOP Xây Dưng Thương Hiệu Cá Nhân',
                'event_photo' => 'banner2.jpg',
                'location' => 'Hội trường B, 53 Võ Văn Ngân, Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh, Trường Cao Đẳng Công Nghệ Thủ Đức',
                'event_start' => Carbon::create('2024', '06', '15', '09', '00', '00'),
                'event_end' => Carbon::create('2024', '06', '15', '11', '00', '00'),
                'point' => 4,
                'registration_start' => Carbon::create('2024', '06', '01', '00', '00', '00'),
                'registration_end' => Carbon::create('2024', '06', '10', '23', '59', '59'),
                'registration_count' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cuộc thi web dev challenge',
                'event_photo' => 'banner3.jpg',
                'location' => 'Hội trường B, 53 Võ Văn Ngân, Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh, Trường Cao Đẳng Công Nghệ Thủ Đức',
                'event_start' => Carbon::create('2024', '06', '20', '10', '00', '00'),
                'event_end' => Carbon::create('2024', '06', '20', '14', '00', '00'),
                'point' => 6,
                'registration_start' => Carbon::create('2024', '06', '05', '00', '00', '00'),
                'registration_end' => Carbon::create('2024', '06', '18', '23', '59', '59'),
                'registration_count' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cuộc thi fit code challenges',
                'event_photo' => 'banner4.jpg',
                'location' => 'Hội trường B, 53 Võ Văn Ngân, Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh, Trường Cao Đẳng Công Nghệ Thủ Đức',
                'event_start' => Carbon::create('2024', '07', '01', '08', '00', '00'),
                'event_end' => Carbon::create('2024', '07', '03', '12', '00', '00'),
                'point' => 5,
                'registration_start' => Carbon::create('2024', '05', '20', '00', '00', '00'),
                'registration_end' => Carbon::create('2024', '05', '30', '23', '59', '59'),
                'registration_count' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('events')->insert($events);
    }
}