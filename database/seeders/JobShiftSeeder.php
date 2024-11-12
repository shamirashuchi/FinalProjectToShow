<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\JobShift;
use Illuminate\Support\Facades\DB;

class JobShiftSeeder extends BaseSeeder
{
    public function run(): void
    {
        JobShift::truncate();
        DB::table('jb_job_shifts_translations')->truncate();

        $data = [
            'First Shift (Day)',
            'Second Shift (Afternoon)',
            'Third Shift (Night)',
            'Rotating',
        ];

        foreach ($data as $item) {
            JobShift::create(['name' => $item]);
        }
    }
}
