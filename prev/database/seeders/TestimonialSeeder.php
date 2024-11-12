<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Slug\Models\Slug;
use Botble\Testimonial\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('testimonials');

        $testimonials = [
            [
                'name' => 'Ellis Kim',
                'company' => 'Digital Artist',
            ],
            [
                'name' => 'John Smith',
                'company' => 'Product designer',
            ],
            [
                'name' => 'Sayen Ahmod',
                'company' => 'Developer',
            ],
            [
                'name' => 'Tayla Swef',
                'company' => 'Graphic designer',
            ],
        ];

        Testimonial::truncate();
        DB::table('testimonials_translations')->truncate();
        Slug::where('reference_type', Testimonial::class)->delete();
        MetaBox::where('reference_type', Testimonial::class)->delete();
        LanguageMeta::where('reference_type', Testimonial::class)->delete();

        foreach ($testimonials as $index => $item) {
            Testimonial::create([
                'name' => $item['name'],
                'company' => $item['company'],
                'image' => 'testimonials/' . ($index + 1) . '.png',
                'content' => fake()->realText(),
            ]);
        }

        $translations = [
            [
                'name' => 'Adam Williams',
                'company' => 'Giám đốc Microsoft',
            ],
            [
                'name' => 'Retha Deowalim',
                'company' => 'Giám đốc Apple',
            ],
            [
                'name' => 'Sam J. Wasim',
                'company' => 'Nhà sáng lập Pio',
            ],
            [
                'name' => 'Usan Gulwarm',
                'company' => 'Giám đốc Facewarm',
            ],
        ];

        foreach ($translations as $index => $item) {
            DB::table('testimonials_translations')->insert([
                'lang_code' => 'vi',
                'name' => $item['name'],
                'company' => $item['company'],
                'content' => fake()->realText(),
                'testimonials_id' => $index + 1,
            ]);
        }
    }
}
