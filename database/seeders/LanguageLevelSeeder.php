<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\LanguageLevel;
use Illuminate\Support\Facades\DB;

class LanguageLevelSeeder extends BaseSeeder
{
    public function run(): void
    {
        LanguageLevel::truncate();
        DB::table('jb_language_levels_translations')->truncate();

        $data = [
            'Expert',
            'Intermediate',
            'Beginner',
        ];

        foreach ($data as $item) {
            LanguageLevel::create(['name' => $item]);
        }
    }
}
