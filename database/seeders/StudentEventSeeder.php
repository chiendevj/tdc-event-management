<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('student_event')->insert(
            [
                'student_id' => '22211TT3000',
                'event_id' => '1', 
            ],
        );
        
        DB::table('student_event')->insert(
            [
                'student_id' => '22211TT3000',
                'event_id' => '2', 
            ],
        );

        DB::table('student_event')->insert(
            [
                'student_id' => '22211TT3000',
                'event_id' => '3', 
            ],
        );

        DB::table('student_event')->insert(
            [
                'student_id' => '22211TT3000',
                'event_id' => '4', 
            ],
        );
    }
}
