<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Models\Category;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use MetaBox;
use SlugHelper;
use Str;

class JobCategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('job-categories');

        Category::truncate();
        DB::table('jb_categories_translations')->truncate();
        MetaBoxModel::where('reference_type', Category::class)->delete();
        Slug::where('reference_type', Category::class)->delete();

        $data = [
            'Content Writer',
            'Market Research',
            'Marketing & Sale',
            'Customer Help',
            'Finance',
            'Software',
            'Human Resource',
            'Management',
            'Retail & Products',
            'Security Analyst',
        ];

        $dataTrans = [
            'vi' => [
                'Nguời viết nội dung',
                'Nghiên cứu thị trường',
                'Tiếp thị',
                'Chăm sóc khách hàng',
                'Tài chính kế toán',
                'Kỹ thuật phần mềm',
                'Quản lý nhân sự',
                'Quản lý',
                'Bán hàng',
                'Phân thích bảo mật',
            ],
        ];

        $imageData = [
            'content',
            'research',
            'marketing',
            'customer',
            'finance',
            'lightning',
            'human',
            'management',
            'retail',
            'security',
        ];

        foreach ($data as $index => $item) {
            $category = Category::create([
                'name' => $item,
                'order' => $index,
                'is_featured' => $index < 8,
            ]);

            MetaBox::saveMetaBoxData($category, 'icon_image', 'general/' . $imageData[$index] . '.png');
            MetaBox::saveMetaBoxData($category, 'job_category_image', 'job-categories/img-cover-' . rand(1, 3) . '.png');

            Slug::create([
                'reference_type' => Category::class,
                'reference_id' => $category->id,
                'key' => Str::slug($category->name),
                'prefix' => SlugHelper::getPrefix(Category::class),
            ]);

            DB::table('jb_categories_translations')->insert([
                'lang_code' => 'vi',
                'jb_categories_id' => $category->id,
                'name' => Arr::get($dataTrans, 'vi.' . $index, $item),
            ]);
        }
    }
}
