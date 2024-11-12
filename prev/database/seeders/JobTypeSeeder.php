<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\JobType;
use Illuminate\Support\Facades\DB;

class JobTypeSeeder extends BaseSeeder
{
    public function run(): void
    {
        JobType::truncate();
        DB::table('jb_job_types_translations')->truncate();

        $data = [
            [
                'name' => 'Contract',
            ],
            [
                'name' => 'Freelance',
            ],
            [
                'name' => 'Full Time',
                'is_default' => 1,
            ],
            [
                'name' => 'Internship',
            ],
            [
                'name' => 'Part Time',
            ],
        ];

        foreach ($data as $item) {
            JobType::create($item);
        }
    }
}
