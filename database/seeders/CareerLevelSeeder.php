<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\CareerLevel;
use Illuminate\Support\Facades\DB;

class CareerLevelSeeder extends BaseSeeder
{
    public function run(): void
    {
        CareerLevel::truncate();
        DB::table('jb_career_levels_translations')->truncate();

        $data = [
            'Department Head',
            'Entry Level',
            'Experienced Professional',
            'GM / CEO / Country Head / President',
            'Intern/Student',
        ];

        foreach ($data as $item) {
            CareerLevel::create(['name' => $item]);
        }
    }
}
