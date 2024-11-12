<?php

namespace Database\Seeders;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\JobBoard\Enums\ModerationStatusEnum;
use Botble\JobBoard\Enums\SalaryRangeEnum;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\CareerLevel;
use Botble\JobBoard\Models\Company;
use Botble\JobBoard\Models\Currency;
use Botble\JobBoard\Models\DegreeLevel;
use Botble\JobBoard\Models\FunctionalArea;
use Botble\JobBoard\Models\Job;
use Botble\JobBoard\Models\JobApplication;
use Botble\JobBoard\Models\JobShift;
use Botble\JobBoard\Models\JobSkill;
use Botble\JobBoard\Models\JobType;
use Botble\JobBoard\Models\Tag;
use Botble\Slug\Models\Slug;
use DB;
use Faker\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MetaBox;
use SlugHelper;

class JobSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('jobs');

        Job::truncate();
        Tag::truncate();
        DB::table('jb_jobs_translations')->truncate();
        JobApplication::truncate();
        DB::table('jb_jobs_categories')->truncate();
        DB::table('jb_jobs_skills')->truncate();
        DB::table('jb_jobs_types')->truncate();
        DB::table('jb_jobs_tags')->truncate();
        Slug::where('reference_type', Job::class)->delete();
        Slug::where('reference_type', Tag::class)->delete();
        MetaBoxModel::where('reference_type', Job::class)->delete();

        $data = [
            'UI / UX Designer fulltime',
            'Full Stack Engineer',
            'Java Software Engineer',
            'Digital Marketing Manager',
            'Frontend Developer',
            'React Native Web Developer',
            'Senior System Engineer',
            'Products Manager',
            'Lead Quality Control QA',
            'Principal Designer, Design Systems',
            'DevOps Architect',
            'Senior Software Engineer, npm CLI',
            'Senior Systems Engineer',
            'Software Engineer Actions Platform',
            'Staff Engineering Manager, Actions',
            'Staff Engineering Manager: Actions Runtime',
            'Staff Engineering Manager, Packages',
            'Staff Software Engineer',
            'Systems Software Engineer',
            'Senior Compensation Analyst',
            'Senior Accessibility Program Manager',
            'Analyst Relations Manager, Application Security',
            'Senior Enterprise Advocate, EMEA',
            'Deal Desk Manager',
            'Director, Revenue Compensation',
            'Program Manager',
            'Sr. Manager, Deal Desk - INTL',
            'Senior Director, Product Management, Actions Runners and Compute Services',
            'Alliances Director',
            'Corporate Sales Representative',
            'Country Leader',
            'Customer Success Architect',
            'DevOps Account Executive - US Public Sector',
            'Enterprise Account Executive',
            'Senior Engineering Manager, Product Security Engineering - Paved Paths',
            'Customer Reliability Engineer III',
            'Support Engineer (Enterprise Support Japanese)',
            'Technical Partner Manager',
            'Sr Manager, Inside Account Management',
            'Services Sales Representative',
            'Services Delivery Manager',
            'Senior Solutions Engineer',
            'Senior Service Delivery Engineer',
            'Senior Director, Global Sales Development',
            'Partner Program Manager',
            'Principal Cloud Solutions Engineer',
            'Senior Cloud Solutions Engineer',
            'Senior Customer Success Manager',
            'Inside Account Manager',
            'UX Jobs Board',
            'Senior Laravel Developer (TALL Stack)',
        ];

        $tags = [
            'Illustrator',
            'Adobe XD',
            'Figma',
            'Sketch',
            'Lunacy',
            'PHP',
            'Python',
            'JavaScript'
        ];

        foreach ($tags as $tag) {
            $tag = Tag::create([
                'name' => $tag,
                'description' => '',
                'status' => BaseStatusEnum::PUBLISHED,
            ]);

            Slug::create([
                'reference_type' => Tag::class,
                'reference_id' => $tag->id,
                'key' => Str::slug($tag->name),
                'prefix' => SlugHelper::getPrefix(Tag::class),
            ]);
        }

        $jobTypeCount = JobType::count();
        $jobExperienceCount = JobType::count();
        $jobSkillCount = JobSkill::count();
        $jobTagCount = Tag::count();
        $careerLevelCount = CareerLevel::count();
        $currencyCount = Currency::count();
        $degreeLevelCount = DegreeLevel::count();
        $jobShiftCount = JobShift::count();
        $functionalAreaCount = FunctionalArea::count();

        $fake = Factory::create();

        $content = '<h5>Responsibilities</h5>
                <div>
                    <p>As a Product Designer, you will work within a Product Delivery Team fused with UX, engineering, product and data talent.</p>
                    <ul>
                        <li>Have sound knowledge of commercial activities.</li>
                        <li>Build next-generation web applications with a focus on the client side</li>
                        <li>Work on multiple projects at once, and consistently meet draft deadlines</li>
                        <li>have already graduated or are currently in any year of study</li>
                        <li>Revise the work of previous designers to create a unified aesthetic for our brand materials</li>
                    </ul>
                </div>
                <h5>Qualification </h5>
                <div>
                    <ul>
                        <li>B.C.A / M.C.A under National University course complete.</li>
                        <li>3 or more years of professional design experience</li>
                        <li>have already graduated or are currently in any year of study</li>
                        <li>Advanced degree or equivalent experience in graphic and web design</li>
                    </ul>
                </div>';

        $companies = Company::all();
        foreach ($data as $index => $item) {
            $company = $companies->random();
            $data = [
                'name' => $item,
                'description' => $fake->text(),
                'content' => $content,
                'company_id' => $company->id,
                'city_id' => $company->city_id,
                'state_id' => $company->state_id,
                'country_id' => $company->country_id,
                'latitude' => $company->latitude,
                'longitude' => $company->longitude,
                'job_experience_id' => rand(1, $jobExperienceCount),
                'career_level_id' => rand(1, $careerLevelCount),
                'currency_id' => rand(1, $currencyCount),
                'degree_level_id' => rand(1, $degreeLevelCount),
                'job_shift_id' => rand(1, $jobShiftCount),
                'functional_area_id' => rand(1, $functionalAreaCount),
                'salary_from' => Arr::random([500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500]),
                'salary_to' => Arr::random([2000, 2100, 2200, 2300, 2400, 2500, 2600, 2700, 2800, 2900, 3000]),
                'salary_range' => Arr::random(SalaryRangeEnum::values()),
                'number_of_positions' => rand(2, 10),
                'never_expired' => rand(0, 1),
                'is_featured' => rand(0, 1),
                'moderation_status' => ModerationStatusEnum::APPROVED,
                'author_id' => 1,
                'author_type' => Account::class,
                'created_at' => $fake->dateTimeBetween('-2 months'),
                'apply_url' => $index == 1 ? 'https://google.com' : null,
                'hide_company' => false,
                'expire_date' => $fake->dateTimeBetween('+5 days', '+2 months'),
            ];

            $job = Job::create($data);

            $job->categories()->attach([1, rand(1, 5), rand(6, 10)]);
            $job->skills()->attach([rand(1, $jobSkillCount)]);
            $job->jobTypes()->attach([rand(1, $jobTypeCount)]);
            $job->tags()->sync([rand(1, $jobTagCount / 2), rand(($jobTagCount / 2) + 1, $jobTagCount)]);

            Slug::create([
                'reference_type' => Job::class,
                'reference_id' => $job->id,
                'key' => Str::slug($job->name),
                'prefix' => SlugHelper::getPrefix(Job::class),
            ]);

            MetaBox::saveMetaBoxData($job, 'featured_image', 'jobs/img' . (($index + 1) > 9 ? rand(1, 9) : ($index + 1)) . '.png');
        }

        $translations = [
            'Thiết kế UI / UX',
            'Lập trình viên full stack',
            'Lập trình viên Java',
            'Quản lý tiếp thị online',
            'Lập trình viên frontend',
            'Lập trình viên React Native',
            'Senior kỹ sư hệ thống',
            'Quản lý sản phẩm',
            'Nhà thiết kế hệ thống',
            'Kiến trúc sư DevOps',
            'Kỹ sư phần mềm cao cấp, npm CLI',
            'Kỹ sư hệ thống cao cấp',
            'Kỹ sư phần mềm nền tảng hành động',
            'Nhân viên Quản lý Kỹ thuật, Actions',
            'Nhân viên Quản lý Kỹ thuật: Actions Runtime',
            'Nhân viên Trưởng phòng Kỹ thuật, Packages',
            'Nhân viên Kỹ sư phần mềm',
            'Kỹ sư phần mềm hệ thống',
            'Chuyên viên phân tích bồi thường cao cấp',
            'Người quản lý chương trình Accessibility cấp cao',
            'Giám đốc quan hệ phân tích, Bảo mật ứng dụng',
            'Advocate doanh nghiệp cấp cao, EMEA',
            'Quản lý bàn giao dịch',
            'Giám đốc, Bồi thường doanh thu',
            'Quản lý chương trình',
            'Sr. Manager, Deal Desk - INTL',
            'Giám đốc cấp cao, Quản lý sản phẩm và Dịch vụ điện toán',
            'Giám đốc Alliances',
            'Đại diện bán hàng của công ty',
            'Lãnh đạo đất nước',
            'Kiến trúc sư khách hàng',
            'Nhân viên điều hành tài khoản DevOps',
            'Kế toán doanh nghiệp',
            'Giám đốc kỹ thuật cấp cao, Kỹ thuật bảo mật sản phẩm',
            'Kỹ sư độ tin cậy của khách hàng III',
            'Kỹ sư hỗ trợ (Tiếng Nhật hỗ trợ doanh nghiệp)',
            'Giám đốc đối tác kỹ thuật',
            'Quản lý tài khoản nội bộ',
            'Đại diện kinh doanh dịch vụ',
            'Giám đốc cung cấp dịch vụ',
            'Kỹ sư giải pháp cao cấp',
            'Kỹ sư cung cấp dịch vụ cao cấp',
            'Giám đốc cấp cao, Phát triển kinh doanh toàn cầu',
            'Giám đốc chương trình đối tác',
            'Kỹ sư giải pháp đám mây chính',
            'Kỹ sư giải pháp đám mây cao cấp',
            'Giám đốc khách hàng cao cấp',
            'Quản lý tài khoản insider',
            'UX Jobs Board',
            'Lập trình viên Laravel Senior (TALL Stack)',
        ];

        $content = '<h5> Trách nhiệm </h5>
            <div>
                <p>Với tư cách là Nhà thiết kế sản phẩm, bạn sẽ làm việc trong Nhóm phân phối sản phẩm kết hợp với UX, kỹ thuật, sản phẩm và tài năng dữ liệu. </p>
                <ul>
                    <li>Có kiến thức vững chắc về các hoạt động thương mại. </li>
                    <li>Xây dựng các ứng dụng web thế hệ tiếp theo tập trung vào phía khách hàng </li>
                    <li>Làm việc trên nhiều dự án cùng một lúc và luôn đáp ứng các thời hạn dự thảo </li>
                    <li>Đã tốt nghiệp hoặc đang trong bất kỳ năm học nào </li>
                    <li>Chỉnh sửa công việc của các nhà thiết kế trước để tạo ra một thẩm mỹ thống nhất cho các vật liệu thương hiệu của chúng tôi </li>
                </ul>
            </div>
            <h5> Chứng chỉ </h5>
            <div>
                <ul>
                    <li>B.C.A / M.C.A trong khoá học của Đại học Quốc gia đã hoàn thành. </li>
                    <li>3 năm kinh nghiệm thiết kế chuyên nghiệp trở lên </li>
                    <li>Đã tốt nghiệp hoặc đang trong bất kỳ năm học nào </li>
                    <li>Bằng cấp cao hoặc kinh nghiệm tương đương trong thiết kế đồ họa và web </li>
                </ul>
            </div>';

        foreach ($translations as $index => $item) {
            DB::table('jb_jobs_translations')->insert([
                'lang_code' => 'vi',
                'name' => $item,
                'content' => $content,
                'description' => $fake->text(),
                'jb_jobs_id' => $index + 1,
            ]);
        }
    }
}
