<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\JobSkill;
use Illuminate\Support\Facades\DB;

class JobSkillSeeder extends BaseSeeder
{
    public function run(): void
    {
        JobSkill::truncate();
        DB::table('jb_job_skills_translations')->truncate();

        $data = [
            'Javascript',
            'PHP',
            'Python',
            'Laravel',
            'CakePHP',
            'Wordpress',
        ];

        foreach ($data as $item) {
            JobSkill::create(['name' => $item]);
        }
    }
}
