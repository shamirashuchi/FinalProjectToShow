<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\DegreeLevel;
use Illuminate\Support\Facades\DB;

class DegreeLevelSeeder extends BaseSeeder
{
    public function run(): void
    {
        DegreeLevel::truncate();
        DB::table('jb_degree_levels_translations')->truncate();

        $data = [
            1 => 'Non-Matriculation',
            2 => 'Matriculation/O-Level',
            3 => 'Intermediate/A-Level',
            4 => 'Bachelors',
            5 => 'Masters',
            6 => 'MPhil/MS',
            7 => 'PHD/Doctorate',
            8 => 'Certification',
            9 => 'Diploma',
            10 => 'Short Course',
        ];

        foreach ($data as $id => $item) {
            DegreeLevel::create(['id' => $id, 'name' => $item]);
        }
    }
}
