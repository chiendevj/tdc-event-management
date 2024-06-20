<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('students')->insert(
            [
                'student_id' => '22211TT3000',
                'email' => '22211TT3000@mail.tdc.edu.vn',
                'fullname' => 'Trần Trung Chiến',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT2029',
                'email' => '22211TT2029@mail.tdc.edu.vn',
                'fullname' => 'Đỗ Ngọc Hiếu',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT2461',
                'email' => '22211TT2461@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Văn Hoàng',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT2661',
                'email' => '22211TT2661@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Tiến Đạt',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT3807',
                'email' => '22211TT3807@mail.tdc.edu.vn',
                'fullname' => 'Ngô Định An',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT0744',
                'email' => '22211TT0744@mail.tdc.edu.vn',
                'fullname' => 'Huỳnh Lý Đình Châu',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT1357',
                'email' => '22211TT1357@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Văn Dư',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT4044',
                'email' => '22211TT4044@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Trọng Hiền',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT4759',
                'email' => '22211TT4759@mail.tdc.edu.vn',
                'fullname' => 'Đỗ Trí Khang',
                'classname' => 'CD23TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT0252',
                'email' => '22211TT0252@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Hữu Khang',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT2577',
                'email' => '22211TT2577@mail.tdc.edu.vn',
                'fullname' => 'Lê Việt Khanh',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT1006',
                'email' => '22211TT1006@mail.tdc.edu.vn',
                'fullname' => 'Hà Nguyễn Bình Minh',
                'classname' => 'CD23TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT2663',
                'email' => '22211TT2663@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Phương Nhi',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT4701',
                'email' => '22211TT4701@mail.tdc.edu.vn',
                'fullname' => 'Trần Hiếu Phúc',
                'classname' => 'CD23TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT1242',
                'email' => '22211TT1242@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Phương Tấn',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT1021',
                'email' => '22211TT1021@mail.tdc.edu.vn',
                'fullname' => 'Tạ Hỷ Nhật Thành',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT4420',
                'email' => '22211TT4420@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Minh Thiết',
                'classname' => 'CD23TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT0253',
                'email' => '22211TT0253@mail.tdc.edu.vn',
                'fullname' => 'Trần Thị Anh Thư',
                'classname' => 'CD22TT11',
            ],
        );

        DB::table('students')->insert(
            [
                'student_id' => '22211TT4921',
                'email' => '22211TT4921@mail.tdc.edu.vn',
                'fullname' => 'Nguyễn Hữu Vinh',
                'classname' => 'CD23TT11',
            ],
        );
    }
}
