<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        function generateUniqueCode()
        {
            do {
                $code = Str::random(6);
            } while (DB::table('event_codes')->where('code', $code)->exists());

            return $code;
        }

        //
        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);

        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);
        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);

        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);
        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);

        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);
        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);

        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);
        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);

        DB::table('event_codes')->insert([
            'link' => 'https://forms.gle/tW3KfuAeFp5Yqc1p8',
            'code' => generateUniqueCode(),
            'event_id' => 1,
        ]);
    }
    
}
