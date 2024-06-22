<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class EventStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        // Lấy danh sách tất cả các sinh viên
        $students = DB::table('students')->pluck('id');

        foreach ($students as $student) {
            // Seed tất cả sinh viên vào event 1
            DB::table('event_student')->insert([
                'student_id' => $student,
                'event_id' => 1,
            ]);

            // Seed vào các event ngẫu nhiên từ 2 đến 4
            $event_ids = range(2, 4);
            shuffle($event_ids);
            $random_event_count = $faker->numberBetween(1, 3); // Số lượng event ngẫu nhiên mà sinh viên tham gia

            for ($i = 0; $i < $random_event_count; $i++) {
                DB::table('event_student')->insert([
                    'student_id' => $student,
                    'event_id' => $event_ids[$i],
                ]);
            }
        }

        // //
        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT3000',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT3000',
        //         'event_id' => '2',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT3000',
        //         'event_id' => '3',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT3000',
        //         'event_id' => '4',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2661',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2661',
        //         'event_id' => '2',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2661',
        //         'event_id' => '3',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2661',
        //         'event_id' => '4',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2461',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2461',
        //         'event_id' => '2',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2461',
        //         'event_id' => '3',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2461',
        //         'event_id' => '4',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT1357',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT1357',
        //         'event_id' => '2',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT1357',
        //         'event_id' => '3',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT1357',
        //         'event_id' => '4',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2029',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2029',
        //         'event_id' => '2',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2029',
        //         'event_id' => '3',
        //     ],
        // );
        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT3807',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT3807',
        //         'event_id' => '4',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT4701',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT4701',
        //         'event_id' => '2',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT4701',
        //         'event_id' => '3',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT4701',
        //         'event_id' => '4',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT1021',
        //         'event_id' => '3',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT1021',
        //         'event_id' => '4',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT4921',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT4921',
        //         'event_id' => '2',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT4921',
        //         'event_id' => '3',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2663',
        //         'event_id' => '1',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2663',
        //         'event_id' => '2',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2663',
        //         'event_id' => '3',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT2663',
        //         'event_id' => '4',
        //     ],
        // );

        // DB::table('event_student')->insert(
        //     [
        //         'student_id' => '22211TT0744',
        //         'event_id' => '1',
        //     ],
        // );
    }
}
