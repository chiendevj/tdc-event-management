<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicPeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $academicPeriods = [
            ['semester' => 1, 'year' => 2021],
            ['semester' => 2, 'year' => 2021],
            ['semester' => "summer", 'year' => 2021],
            ['semester' => 1, 'year' => 2022],
            ['semester' => 2, 'year' => 2022],
            ['semester' => "summer", 'year' => 2022],
            ['semester' => 1, 'year' => 2023],
            ['semester' => 2, 'year' => 2023],
            ['semester' => "summer", 'year' => 2023],
            ['semester' => 1, 'year' => 2024],
            ['semester' => 2, 'year' => 2024],
            ['semester' => "summer", 'year' => 2024],
        ];

        DB::table('academic_periods')->insert($academicPeriods);
    }
}
