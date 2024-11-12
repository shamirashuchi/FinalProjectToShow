<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\JobExperience;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class JobExperienceSeeder extends BaseSeeder
{
    public function run(): void
    {
        JobExperience::truncate();
        DB::table('jb_job_experiences_translations')->truncate();

        $data = [
            'Fresh',
            'Less Than 1 Year',
            '1 Year',
            '2 Year',
            '3 Year',
            '4 Year',
            '5 Year',
            '6 Year',
            '7 Year',
            '8 Year',
            '9 Year',
            '10 Year',
        ];

        $dataTrans = [
            'vi' => [
                'Mới',
                'Dưới 1 năm',
                '1 Năm',
                '2 Năm',
                '3 Năm',
                '4 Năm',
                '5 Năm',
                '6 Năm',
                '7 Năm',
                '8 Năm',
                '9 Năm',
                '10 Năm',
            ],
        ];

        foreach ($data as $index => $item) {
            $job = JobExperience::create(['name' => $item]);
            DB::table('jb_job_experiences_translations')->insert([
                'lang_code' => 'vi',
                'jb_job_experiences_id' => $job->id,
                'name' => Arr::get($dataTrans, 'vi.' . $index, $item),
            ]);
        }
    }
}
