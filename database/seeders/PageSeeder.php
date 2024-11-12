<?php

namespace Database\Seeders;

use BaseHelper;
use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Faker\Factory;
use Html;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MetaBox;
use SlugHelper;

class PageSeeder extends BaseSeeder
{
    public function run(): void
    {
        Page::truncate();
        DB::table('pages_translations')->truncate();
        Slug::where('reference_type', Page::class)->delete();
        MetaBoxModel::where('reference_type', Page::class)->delete();
        LanguageMeta::where('reference_type', Page::class)->delete();

        $faker = Factory::create();

        $this->uploadFiles('pages');
        $this->uploadFiles('galleries');
        $this->uploadFiles('our-partners');

        $pages = [
            1 => [
                'name' => 'Homepage 1',
                'content' =>
                    Html::tag('div', '[search-box title="The Easiest Way to Get Your New Job" highlight_text="Easiest Way" description="Each month, more than 3 million job seekers turn to website in their search for work, making over 140,000 applications every single day" banner_image_1="pages/banner1.png" icon_top_banner="pages/icon-top-banner.png" banner_image_2="pages/banner2.png" icon_bottom_banner="pages/icon-bottom-banner.png" style="style-1" trending_keywords="Design,Development,Manager,Senior"][/search-box]') .
                    Html::tag('div', '[featured-job-categories title="Browse by category" subtitle="Find the job that’s perfect for you. about 800+ new jobs everyday"][/featured-job-categories]') .
                    Html::tag('div', '[apply-banner subtitle="Let’s Work Together &lt;br\&gt;&amp; Explore Opportunities" highlight_sub_title_text="Work, Explore" title_1="We are" title_2="HIRING" button_apply_text="Apply" button_apply_link="#" apply_image_left="pages/bg-left-hiring.png" apply_image_right="pages/bg-right-hiring.png"][/apply-banner]') .
                    Html::tag('div', '[job-of-the-day title="Jobs of the day" subtitle="Search and connect with the right candidates faster." job_categories="4,9,1,3,5,7" style="style-1"][/job-of-the-day]') .
                    Html::tag('div', '[job-grid title="Find The One That’s Right For You" high_light_title_text="Right" subtitle="Millions Of Jobs." description="Search all the open positions on the web. Get your own personalized salary estimate. Read reviews on over 600,000 companies worldwide. The right job is out there." image_job_1="pages/img-chart.png" image_job_2="pages/controlcard.png" image="pages/img1.png" button_text="Search jobs" button_url="#" link_text="Learn more" link_text_url="#"][/job-grid]') .
                    Html::tag('div', '[top-companies title="Top Recruiters" description="Discover your next career move, freelance gig, or internship"][/top-companies]') .
                    Html::tag('div', '[job-by-location title="Jobs by Location" description="Find your favourite jobs and get the benefits of yourself" city="1,2,3,4,5,6"][/job-by-location]') .
                    Html::tag('div', '[news-and-blogs title="News and Blog" subtitle="Get the latest news, updates and tips"][/news-and-blogs]')
                ,
                'template' => 'homepage',
            ],
            2 => [
                'name' => 'Homepage 2',
                'content' =>
                    Html::tag('div', '[search-box subtitle="We have 150,000+ live jobs" title="The #1 Job Board for Hiring or Find your next job" highlight_text="Job Board for" description="Each month, more than 3 million job seekers turn to website in their search for work, making over 140,000 applications every single day" counter_title_1="Daily Jobs Posted" counter_number_1="265" counter_title_2="Recruiters" counter_number_2="17" counter_title_3="Freelancers" counter_number_3="15" counter_title_4="Blog Tips" counter_number_4="28" image="general/img-01.png" background_image="pages/banner-section-search-box.png" style="style-2" trending_keywords="Design,Development,Manager,Senior"][/search-box]') .
                    Html::tag('div', '[job-of-the-day title="Jobs of the day" subtitle="Search and connect with the right candidates faster." job_categories="1,2,5,4,7,8" style="style-2"][/job-of-the-day]') .
                    Html::tag('div', '[popular-category title="Popular category" subtitle="Search and connect with the right candidates faster."][/popular-category]') .
                    Html::tag('div', '[job-by-location title="Jobs by Location" description="Find your favourite jobs and get the benefits of yourself" city="12,46,69,111,121,116,62" style="style-2"][/job-by-location]') .
                    Html::tag('div', '[counter-section counter_title_1="Completed Cases" counter_description_1="We always provide people a complete solution upon focused of any business" counter_number_1="1000" counter_title_2="Our Office" counter_description_2="We always provide people a complete solution upon focused of any business" counter_number_2="1" counter_title_3="Skilled People" counter_description_3="We always provide people a complete solution upon focused of any business" counter_number_3="6" counter_title_4="Happy Clients" counter_description_4="We always provide people a complete solution upon focused of any business" counter_number_4="2"][/counter-section]') .
                    Html::tag('div', '[top-companies title="Top Recruiters" description="Discover your next career move, freelance gig, or internship" style="style-2"][/top-companies]') .
                    Html::tag('div', '[advertisement-banner first_title="Job Tools Services" first_description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet rutrum quam, id faucibus erat interdum a. Curabitur eget tortor a nulla interdum semper." load_more_first_content_text="Find Out More" load_more_link_first_content="#" image_of_first_content="pages/job-tools.png" second_title="Planning a Job?" second_description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet rutrum quam, id faucibus erat interdum a. Curabitur eget tortor a nulla interdum semper." load_more_second_content_text="Find Out More" load_more_link_second_content="#" image_of_second_content="pages/planning-job.png"][/advertisement-banner]') .
                    Html::tag('div', '[news-and-blogs title="News and Blog" subtitle="Get the latest news, updates and tips" button_text="Load More Posts" button_link="#" style="style-2"][/news-and-blogs]')
                ,
                'template' => 'homepage',
            ],
            3 => [
                'name' => 'Homepage 3',
                'content' =>
                    Html::tag('div', '[search-box title="The #1 Job Board for Hiring or Find your next job" highlight_text="Job Board for" description="Each month, more than 3 million job seekers turn to website in their search for work, making over 140,000 applications every single day" style="style-3" trending_keywords="Design,Development,Manager,Senior"][/search-box]') .
                    Html::tag('div', '[job-of-the-day title="Jobs of the day" subtitle="Search and connect with the right candidates faster." job_categories="1,2,5,4,7,8" style="style-3"][/job-of-the-day]') .
                    Html::tag('div', '[top-candidates title="Top Candidates" description="Jobs is a curated job board of the best jobs for developers, designers and marketers in the tech industry." limit="8" style="style-3"][/top-candidates]') .
                    Html::tag('div', '[top-companies title="Top Recruiters" description="Discover your next career move, freelance gig, or internship" style="style-3"][/top-companies]') .
                    Html::tag('div', '[apply-banner subtitle="Let’s Work Together &lt;br\&gt;&amp; Explore Opportunities" highlight_sub_title_text="Work, Explore" title_1="We are" title_2="HIRING" button_apply_text="Apply" button_apply_link="#" apply_image_left="pages/bg-left-hiring.png" apply_image_right="pages/bg-right-hiring.png" style="style-3"][/apply-banner]') .
                    Html::tag('div', '[our-partners title="Trusted by" name_1="Asus" url_1="https://www.asus.com" image_1="our-partners/asus.png" name_2="Dell" url_2="https://www.dell.com" image_2="our-partners/dell.png" name_3="Microsoft" url_3="https://www.microsoft.com" image_3="our-partners/microsoft.png" name_4="Acer" url_4="https://www.acer.com" image_4="our-partners/acer.png" name_5="Nokia" url_5="https://www.nokia.com" image_5="our-partners/nokia.png"][/our-partners]') .
                    Html::tag('div', '[news-and-blogs title="News and Blog" subtitle="Get the latest news, updates and tips" button_text="Load More Posts" button_link="#" style="style-3"][/news-and-blogs]')
                ,
                'template' => 'homepage',
            ],
            4 => [
                'name' => 'Homepage 4',
                'content' =>
                    Html::tag('div', '[search-box title="Get The Right Job You Deserve" highlight_text="Right Job" banner_image_1="pages/home-page-4-banner.png" style="style-1" trending_keywords="Designer, Web, IOS, Developer, PHP, Senior, Engineer" background_color="#000"][/search-box]') .
                    Html::tag('div', '[job-of-the-day title="Latest Jobs Post" subtitle="Explore the different types of available jobs to apply discover which is right for you." job_categories="1,2,3,4,5,6,8,7" style="style-3"][/job-of-the-day]') .
                    Html::tag('div', '[featured-job-categories title="Browse by category" subtitle="Find the job that’s perfect for you. about 800+ new jobs everyday" limit_category="10" background_image="pages/bg-cat.png" style="style-2"][/featured-job-categories]') .
                    Html::tag('div', '[[testimonials title="See Some Words" description="Thousands of employee get their ideal jobs and feed back to us!" style="style-2"][/testimonials]') .
                    Html::tag('div', '[our-partners title="Trusted by" name_1="Asus" url_1="https://www.asus.com" image_1="our-partners/asus.png" name_2="Dell" url_2="https://www.dell.com" image_2="our-partners/dell.png" name_3="Microsoft" url_3="https://www.microsoft.com" image_3="our-partners/microsoft.png" name_4="Acer" url_4="https://www.acer.com" image_4="our-partners/acer.png" name_5="Nokia" url_5="https://www.nokia.com" image_5="our-partners/nokia.png"][/our-partners]') .
                    Html::tag('div', '[popular-category title="Popular category" subtitle="Search and connect with the right candidates faster."][/popular-category]') .
                    Html::tag('div', '[job-by-location title="Jobs by Location" description="Find your favourite jobs and get the benefits of yourself" city="12,46,69,111,121,116,62" style="style-2"][/job-by-location]') .
                    Html::tag('div', '[news-and-blogs title="News and Blog" subtitle="Get the latest news, updates and tips" button_text="Load More Posts" button_link="#"][/news-and-blogs]')
                ,
                'template' => 'homepage',
            ],
            5 => [
                'name' => 'Homepage 5',
                'content' =>
                    Html::tag('div', '[search-box title="Find Jobs, &#x3C;br&#x3E; Hire Creatives" description="Each month, more than 3 million job seekers turn to website in their search for work, making over 140,000 applications every single day" banner_image_1="pages/banner1.png" banner_image_2="pages/banner2.png" banner_image_3="pages/banner3.png" banner_image_4="pages/banner4.png" banner_image_5="pages/banner5.png" banner_image_6="pages/banner6.png" style="style-5"][/search-box]') .
                    Html::tag('div', '[counter-section counter_title_1="Completed Cases" counter_description_1="We always provide people a complete solution upon focused of any business" counter_number_1="1000" counter_title_2="Our Office" counter_description_2="We always provide people a complete solution upon focused of any business" counter_number_2="1" counter_title_3="Skilled People" counter_description_3="We always provide people a complete solution upon focused of any business" counter_number_3="6" counter_title_4="Happy Clients" counter_description_4="We always provide people a complete solution upon focused of any business" counter_number_4="2"][/counter-section]') .
                    Html::tag('div', '[popular-category title="Explore the Marketplace" subtitle="Search and connect with the right candidates faster. Tell us what you’ve looking for and we’ll get to work for you." style="style-5"][/popular-category]') .
                    Html::tag('div', '[job-of-the-day title="Latest Jobs Post" subtitle="Explore the different types of available jobs to apply &#x3C;br&#x3E; discover which is right for you." job_categories="1,2,5,4,7,8" style="style-2"][/job-of-the-day]') .
                    Html::tag('div', '[job-grid style="style-2" title="Create Your Personal Account Profile" subtitle="Create Profile" description="Work Profile is a personality assessment that measures an individual\'s work personality through their workplace traits, social and emotional traits; as well as the values and aspirations that drive them forward." image="pages/img-profile.png" button_text="Create Profile" button_url="/register"][/job-grid]') .
                    Html::tag('div', '[how-it-works title="How It Works" description="Just via some simple steps, you will find your ideal candidates you’r looking for!" step_label_1="Register an &#x3C;br&#x3E; account to start" step_help_1="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do" step_label_2="Explore over &#x3C;br&#x3E; thousands of resumes" step_help_2="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do" step_label_3="Find the most &#x3C;br&#x3E; suitable candidate" step_help_3="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do" button_label="Get Started" button_url="#"][/how-it-works]') .
                    Html::tag('div', '[top-candidates title="Top Candidates" description="Jobs is a curated job board of the best jobs for developers, designers &#x3C;br&#x3E; and marketers in the tech industry." limit="8" style="style-5"][/top-candidates]') .
                    Html::tag('div', '[news-and-blogs title="News and Blog" subtitle="Get the latest news, updates and tips" button_text="Load More Posts" button_link="#" style="style-2"][/news-and-blogs]')
                ,
                'template' => 'homepage',
            ],
            6 => [
                'name' => 'Homepage 6',
                'content' =>
                    Html::tag('div', '[search-box title="There Are 102,256 Postings Here For you!" highlight_text="102,256" description="Find Jobs, Employment & Career Opportunities" style="style-4" trending_keywords="Design,Development,Manager,Senior,," background_color="#000"][/search-box]') .
                    Html::tag('div', '[gallery image_1="galleries/1.jpg" image_2="galleries/2.jpg" image_3="galleries/3.jpg" image_4="galleries/4.jpg" image_5="galleries/5.jpg"][/gallery]') .
                    Html::tag('div', '[featured-job-categories title="Browse by category" subtitle="Find the job that’s perfect for you. about 800+ new jobs everyday"][/featured-job-categories]') .
                    Html::tag('div', '[job-grid style="style-2" title="Create Your Personal Account Profile" subtitle="Create Profile" description="Work Profile is a personality assessment that measures an individual\'s work personality through their workplace traits, social and emotional traits; as well as the values and aspirations that drive them forward." image="pages/img-profile.png" button_text="Create Profile" button_url="/register"][/job-grid]') .
                    Html::tag('div', '[job-of-the-day title="Latest Jobs Post" subtitle="Explore the different types of available jobs to apply discover which is right for you." job_categories="1,2,3,4,5,6" style="style-2"][/job-of-the-day]') .
                    Html::tag('div', '[job-search-banner title="Job search for people passionate about startup" background_image="pages/img-job-search.png" checkbox_title_1="Create an account" checkbox_description_1="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec justo a quam varius maximus. Maecenas sodales tortor quis tincidunt commodo." checkbox_title_2="Search for Jobs" checkbox_description_2="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec justo a quam varius maximus. Maecenas sodales tortor quis tincidunt commodo." checkbox_title_3="Save & Apply" checkbox_description_3="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec justo a quam varius maximus. Maecenas sodales tortor quis tincidunt commodo."][/job-search-banner]')
                ,
                'template' => 'homepage',
            ],
            7 => [
                'name' => 'Jobs',
                'content' =>
                    Html::tag('div', '[search-box title="The official IT Jobs site" highlight_text="IT Jobs" description="“JobBox is our first stop whenever we\'re hiring a PHP role. We\'ve hired 10 PHP developers in the last few years, all thanks to JobBox.” — Andrew Hall, Elite JSC." banner_image_1="pages/left-job-head.png" banner_image_2="pages/right-job-head.png" style="style-3" background_color="#000"][/search-box]') .
                    Html::tag('div', '[job-list max_salary_range="100000"][/job-list]')
                ,
            ],
            8 => [
                'name' => 'Companies',
                'content' =>
                    Html::tag('div', '[job-companies title="Browse Companies" subtitle="Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero repellendus magni, atque delectus molestias quis?"][/job-companies]')
                ,
            ],
            9 => [
                'name' => 'Candidates',
                'slug' => 'candidates',
                'content' =>
                    Html::tag('div', '[job-candidates title="Browse Candidates" description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero repellendus magni, atque &#x3C;br&#x3E; delectus molestias quis?" number_per_page="9" style="grid"][/job-candidates]') .
                    Html::tag('div', '[news-and-blogs title="News and Blog" subtitle="Get the latest news, updates and tips" style="style-2"][/news-and-blogs]')
                ,
            ],
            10 => [
                'name' => 'About us',
                'content' =>
                    Html::tag('div', '[company-about title="About Our Company" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ligula ante, dictum non aliquet eu, dapibus ac quam. Morbi vel ante viverra orci tincidunt tempor eu id ipsum. Sed consectetur, risus a blandit tempor, velit magna pellentesque risus, at congue tellus dui quis nisl." title_box="What we can do?" image="general/img-about2.png" description_box="Aenean sollicituin, lorem quis bibendum auctor nisi elit consequat ipsum sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet maurisorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctora ornare odio. Aenean sollicituin, lorem quis bibendum auctor nisi elit consequat ipsum sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet maurisorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctora ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis non nisi purus. Integer sit nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis non nisi purus. Integer sit nostra, per inceptos himenaeos." url="/" text_button_box="Read more"][/company-about]') .
                    Html::tag('div', '[team title="About Our Company" sub_title="OUR COMPANY" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ligula ante, dictum non aliquet eu, dapibus ac quam. Morbi vel ante viverra orci tincidunt tempor eu id ipsum. Sed consectetur, risus a blandit tempor, velit magna pellentesque risus, at congue tellus dui quis nisl." number_of_people="8"][/team]') .
                    Html::tag('div', '[news-and-blogs title="News and Blog" subtitle="Get the latest news, updates and tips" button_text="View More" button_link="/blog" style="style-2"][/news-and-blogs]') .
                    Html::tag('div', '[testimonials title="Our Happy Customer" description="When it comes to choosing the right web hosting provider, we know how easy it is to get overwhelmed with the number."][/testimonials]')
                ,

                'template' => 'page-detail',
                'description' => 'Get the latest news, updates and tips',
                'background_breadcrumb' => 'pages/background_breadcrumb.png',
            ],
            11 => [
                'name' => 'Pricing Plan',
                'content' =>
                    Html::tag('div', '[pricing-table title="Pricing Table" subtitle="Choose The Best Plan That’s For You" number_of_package="3"][/pricing-table]') .
                    Html::tag('div', '[faq title="Frequently Asked Questions" subtitle="Aliquam a augue suscipit, luctus neque purus ipsum neque dolor primis a libero tempus, blandit and cursus varius and magnis sapien" number_of_faq="4"][/faq]') .
                    Html::tag('div', '[testimonials title="Our Happy Customer" subtitle="When it comes to choosing the right web hosting provider, we know how easy it is to get overwhelmed with the number."][/testimonials]')
                ,
            ],
            12 => [
                'name' => 'Contact',
                'content' =>
                    Html::tag('div', '[company-information company_name="Jobbox Company" logo_company="general/logo-company.png" company_address="205 North Michigan Avenue, Suite 810 Chicago, 60601, US" company_phone="0543213336" company_email="contact@jobbox.com" branch_company_name_0="London" branch_company_address_0="2118 Thornridge Cir. Syracuse, Connecticut 35624" branch_company_name_1="New York" branch_company_address_1="4517 Washington Ave. Manchester, Kentucky 39495" branch_company_name_2="Chicago" branch_company_address_2="3891 Ranchview Dr. Richardson, California 62639" branch_company_name_3="San Francisco" branch_company_address_3="4140 Parker Rd. Allentown, New Mexico 31134" branch_company_name_4="Sysney" branch_company_address_4="3891 Ranchview Dr. Richardson, California 62639" branch_company_name_5="Singapore" branch_company_address_5="4140 Parker Rd. Allentown, New Mexico 31134"][/company-information]') .
                    Html::tag('div', '[contact-form title="Contact us" subtitle="Get in touch" description="The right move at the right time saves your investment. live the dream of expanding your business." image="image-contact.png" show_newsletter="yes"][/contact-form]') .
                    Html::tag('div', '[team title="Meet Our Team" subtitle="OUR COMPANY" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ligula ante, dictum non aliquet eu, dapibus ac quam. Morbi vel ante viverra orci tincidunt tempor eu id ipsum. Sed consectetur, risus a blandit tempor, velit magna pellentesque risus, at congue tellus dui quis nisl." number_of_people="8"][/team]') .
                    Html::tag('div', '[news-and-blogs title="News and Blog" subtitle="Get the latest news, updates and tips" button_text="View More" button_link="/blog" style="style-2"][/news-and-blogs]') .
                    Html::tag('div', '[testimonials title="Our Happy Customer" subtitle="When it comes to choosing the right web hosting provider, we know how easy it is to get overwhelmed with the number."][/testimonials]')
                ,

                'template' => 'page-detail',
                'description' => 'Get the latest news, updates and tips',
                'background_breadcrumb' => 'pages/background_breadcrumb.png',
            ],
            13 => [
                'name' => 'Blog',
                'content' => '---',
                'template' => 'page-detail',
                'description' => 'Get the latest news, updates and tips',
            ],
            14 => [
                'name' => 'Cookie Policy',
                'content' => Html::tag('h3', 'EU Cookie Consent') .
                    Html::tag(
                        'p',
                        'To use this website we are using Cookies and collecting some Data. To be compliant with the EU GDPR we give you to choose if you allow us to use certain Cookies and to collect some Data.'
                    ) .
                    Html::tag('h4', 'Essential Data') .
                    Html::tag(
                        'ul',
                        Html::tag(
                            'li',
                            'The Essential Data is needed to run the Site you are visiting technically. You can not deactivate them.'
                        ) .
                        Html::tag(
                            'li',
                            'Session Cookie: PHP uses a Cookie to identify user sessions. Without this Cookie the Website is not working.'
                        ) .
                        Html::tag(
                            'li',
                            'XSRF-Token Cookie: Laravel automatically generates a CSRF "token" for each active user session managed by the application. This token is used to verify that the authenticated user is the one actually making the requests to the application.'
                        )
                    )
                ,
                'template' => 'static',
            ],
            15 => [
                'name' => 'FAQ',
                'content' => Html::tag('div', '[faq title="Frequently Asked Questions"][/faq]')
                ,
            ],
            16 => [
                'name' => 'Services',
                'template' => 'static',
            ],
            17 => [
                'name' => 'Terms',
                'template' => 'static',
            ],
            18 => [
                'name' => 'Coming Soon',
                'content' =>
                    Html::tag('div', '[coming-soon title="We’re Launching Soon..!!" subtitle="Start working with JobBox that can provide everything you need to generate awareness, drive traffic, connect." date="' . BaseHelper::formatDate(now()->addMonths(1)) . '" time="00:00" image="general/animat-rocket-color.gif"][/coming-soon]')
                ,
                'template' => 'coming-soon',
            ],
            19 => [
                'name' => 'Job Categories',
                'content' =>
                    Html::tag('div', '[search-box title="22 Jobs Available Now" highlight_text="22 Jobs" description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero repellendus magni, atque delectus molestias quis?" banner_image_1="pages/left-job-head.png" banner_image_2="pages/right-job-head.png" style="style-3" background_color="#000"][/search-box]') .
                    Html::tag('div', '[popular-category title="Popular category" limit_category="8" style="style-1"][/popular-category]') .
                    Html::tag('div', '[job-categories title="Categories" subtitle="All categories" limit_category="8"][/job-categories]')
                ,
            ],
        ];

        foreach ($pages as $item) {
            $item['user_id'] = 1;

            if (! isset($item['template'])) {
                $item['template'] = 'default';
            }

            if (! isset($item['content'])) {
                $item['content'] = Html::tag('p', $faker->realText(500)) . Html::tag('p', $faker->realText(500)) .
                    Html::tag('p', $faker->realText(500)) . Html::tag('p', $faker->realText(500));
            }

            $page = Page::create(Arr::except($item, ['slug', 'background_breadcrumb']));

            if (isset($item['background_breadcrumb'])) {
                MetaBox::saveMetaBoxData($page, 'background_breadcrumb', $item['background_breadcrumb']);
            }

            Slug::create([
                'reference_type' => Page::class,
                'reference_id' => $page->id,
                'key' => $item['slug'] ?? Str::slug($page->name)
                ,
                'prefix' => SlugHelper::getPrefix(Page::class)
                ,
            ]);
        }

        $translations = [
            [
                'name' => 'Trang chủ 1',
                'content' =>
                    Html::tag('div', '[search-box title="Cách Dễ Dàng Nhất Để Bạn Có Được Công Việc Mới" highlight_text="Dễ Dàng Nhất" description="Mỗi tháng, hơn 3 triệu người tìm việc truy cập trang web để tìm việc, thực hiện hơn 140.000 đơn đăng ký mỗi ngày" banner_image_1="pages/banner1.png" icon_top_banner="pages/icon-top-banner.png" banner_image_2="pages/banner2.png" icon_bottom_banner="pages/icon-bottom-banner.png" style="style-1" trending_keywords="Design,Development,Manager,Senior"][/search-box]') .
                    Html::tag('div', '[featured-job-categories title="Tìm kiếm theo Danh Mục" subtitle="Tìm công việc phù hợp với bạn. Khoảng hơn 800 công việc mới mỗi ngày"][/featured-job-categories]') .
                    Html::tag('div', '[apply-banner subtitle="Hãy Làm Việc Cùng Nhau &lt;br\&gt;&amp; Khám Phá Cơ Hội" highlight_sub_title_text="Làm Việc, Khám Phá" title_1="Chúng tôi đang" title_2="TUYỂN DỤNG" button_apply_text="Ứng Tuyển" button_apply_link="#" apply_image_left="pages/bg-left-hiring.png" apply_image_right="pages/bg-right-hiring.png"][/apply-banner]') .
                    Html::tag('div', '[job-of-the-day title="Công việc trong ngày" subtitle="Tìm kiếm và kết nối với các ứng viên phù hợp nhanh hơn." job_categories="1,2,5,4,7,8" style="style-2"][/job-of-the-day]') .
                    Html::tag('div', '[job-grid title="Tìm Người Phù Hợp Với Bạn" high_light_title_text="Phù Hợp" subtitle="Hàng Triệu Công Việc." description="Tìm kiếm tất cả các vị trí mở trên web. Nhận ước tính tiền lương cá nhân của riêng bạn. Đọc đánh giá về hơn 600.000 công ty trên toàn thế giới. Công việc phù hợp đang ở ngoài đó." image_job_1="pages/img-chart.png" image_job_2="pages/controlcard.png" image="pages/img1.png" button_text="Tìm công việc" button_url="#" link_text="Learn more" link_text_url="#"][/job-grid]') .
                    Html::tag('div', '[top-companies title="Nhà Tuyển Dụng Hàng Đầu" description="Khám phá bước chuyển nghề nghiệp tiếp theo của bạn, hợp đồng biểu diễn tự do hoặc thực tập"][/top-companies]') .
                    Html::tag('div', '[job-by-location title="Việc làm theo Vị trí" description="Tìm công việc yêu thích của bạn và nhận được những lợi ích của chính mình" city="1,2,3,4,5,6"][/job-by-location]') .
                    Html::tag('div', '[news-and-blogs title="Tin tức và Blog" subtitle="Nhận tin tức, cập nhật và mẹo mới nhất"][/news-and-blogs]')
                ,
            ],
            [
                'name' => 'Trang chủ 2',
                'content' =>
                    Html::tag('div', '[search-box subtitle="Chúng tôi có hơn 150.000 việc làm trực tiếp" title="Bảng việc làm số 1 để tuyển dụng hoặc tìm công việc tiếp theo của bạn" highlight_text="Bảng việc làm" description="Mỗi tháng, hơn 3 triệu người tìm việc truy cập trang web để tìm việc, thực hiện hơn 140.000 đơn đăng ký mỗi ngày" counter_title_1="Công việc hàng ngày được đăng" counter_number_1="265" counter_title_2="Nhà tuyển dụng" counter_number_2="17" counter_title_3="" counter_number_3="15" counter_title_4="Blog Tips" counter_number_4="28" image="general/img-01.png" background_image="pages/banner-section-search-box.png" style="style-2" trending_keywords="Design,Development,Manager,Senior"][/search-box]') .
                    Html::tag('div', '[job-of-the-day title="Công việc trong ngày" subtitle="Tìm kiếm và kết nối với các ứng viên phù hợp nhanh hơn." job_categories="1,2,5,4,7,8" style="style-1"][/job-of-the-day]') .
                    Html::tag('div', '[popular-category title="Danh mục phổ biến" subtitle="Tìm kiếm và kết nối với các ứng viên phù hợp nhanh hơn."][/popular-category]') .
                    Html::tag('div', '[job-by-location title="Việc làm theo Vị trí" description="Tìm công việc yêu thích của bạn và nhận được những lợi ích của chính mình" city="12,46,69,111,121,116,62" style="style-2"][/job-by-location]') .
                    Html::tag('div', '[counter-section counter_title_1="Các trường hợp đã hoàn thành" counter_description_1="Chúng tôi luôn cung cấp cho mọi người một giải pháp hoàn chỉnh dựa trên trọng tâm của bất kỳ doanh nghiệp nào" counter_number_1="1000" counter_title_2="Văn Phòng Của Chúng Tôi" counter_description_2="Chúng tôi luôn cung cấp cho mọi người một giải pháp hoàn chỉnh dựa trên trọng tâm của bất kỳ doanh nghiệp nào" counter_number_2="1" counter_title_3="Người lành nghề" counter_description_3="Chúng tôi luôn cung cấp cho mọi người một giải pháp hoàn chỉnh dựa trên trọng tâm của bất kỳ doanh nghiệp nào" counter_number_3="6" counter_title_4="Khách hàng hạnh phúc" counter_description_4="Chúng tôi luôn cung cấp cho mọi người một giải pháp hoàn chỉnh dựa trên trọng tâm của bất kỳ doanh nghiệp nào" counter_number_4="2"][/counter-section]') .
                    Html::tag('div', '[top-companies title="Nhà Tuyển Dụng Hàng Đầu" description="Khám phá bước chuyển nghề nghiệp tiếp theo của bạn, hợp đồng biểu diễn tự do hoặc thực tập"][/top-companies]') .
                    Html::tag('div', '[advertisement-banner first_title="Dịch vụ công cụ việc làm" first_description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet rutrum quam, id faucibus erat interdum a. Curabitur eget tortor a nulla interdum semper." load_more_first_content_text="Tìm hiểu thêm" load_more_link_first_content="#" image_of_first_content="pages/job-tools.png" second_title="Planning a Job?" second_description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet rutrum quam, id faucibus erat interdum a. Curabitur eget tortor a nulla interdum semper." load_more_second_content_text="Find Out More" load_more_link_second_content="#" image_of_second_content="pages/planning-job.png"][/advertisement-banner]') .
                    Html::tag('div', '[news-and-blogs title="Tin tức và Blog" subtitle="Nhận tin tức, cập nhật và mẹo mới nhất" button_text="Tải thêm bài viết" button_link="#" style="style-2"][/news-and-blogs]')
                ,
            ],
            [
                'name' => 'Trang chủ 3',
                'content' =>
                    Html::tag('div', '[search-box title="Bảng việc làm số 1 để tuyển dụng hoặc tìm công việc tiếp theo của bạn" highlight_text="Bảng công việc cho" description="Mỗi tháng, hơn 3 triệu người tìm việc truy cập trang web để tìm việc, thực hiện hơn 140.000 đơn đăng ký mỗi ngày" style="style-3" trending_keywords="Design,Development,Manager,Senior"][/search-box]') .
                    Html::tag('div', '[job-of-the-day title="Công việc trong ngày" subtitle="Tìm kiếm và kết nối với các ứng viên phù hợp nhanh hơn." job_categories="1,2,5,4,7,8" style="style-3"][/job-of-the-day]') .
                    Html::tag('div', '[top-candidates title="Ứng viên hàng đầu" description="Việc làm là một job board tuyển chọn các công việc tốt nhất dành cho nhà phát triển, nhà thiết kế và nhà tiếp thị trong ngành công nghệ." limit="8" style="style-3"][/top-candidates]') .
                    Html::tag('div', '[top-companies title="Nhà tuyển dụng hàng đầu" description="Khám phá bước chuyển nghề nghiệp tiếp theo của bạn, hợp đồng biểu diễn tự do hoặc thực tập" style="style-3"][/top-companies]') .
                    Html::tag('div', '[apply-banner subtitle="Hãy làm việc cùng nhau &lt;br\&gt;&amp; khám phá cơ hội" highlight_sub_title_text="Làm việc, Khám phá" title_1="We are" title_2="HIRING" button_apply_text="Ứng tuyển" button_apply_link="#" apply_image_left="pages/bg-left-hiring.png" apply_image_right="pages/bg-right-hiring.png" style="style-3"][/apply-banner]') .
                    Html::tag('div', '[our-partners title="Trusted by" name_1="Asus" url_1="https://www.asus.com" image_1="our-partners/asus.png" name_2="Dell" url_2="https://www.dell.com" image_2="our-partners/dell.png" name_3="Microsoft" url_3="https://www.microsoft.com" image_3="our-partners/microsoft.png" name_4="Acer" url_4="https://www.acer.com" image_4="our-partners/acer.png" name_5="Nokia" url_5="https://www.nokia.com" image_5="our-partners/nokia.png"][/our-partners]') .
                    Html::tag('div', '[news-and-blogs title="Tin tức và blog" subtitle="Nhận tin tức, cập nhật và mẹo mới nhất" button_text="Tải thêm bài viết" button_link="#" style="style-3"][/news-and-blogs]')
                ,
            ],
            [
                'name' => 'Trang chủ 4',
                'content' =>
                    Html::tag('div', '[search-box title="Tìm đúng công việc bạn xứng đáng" highlight_text="Đúng việc" banner_image_1="pages/home-page-4-banner.png" style="style-1" trending_keywords="Designer, Web, IOS, Developer, PHP, Senior, Engineer" background_color="#000"][/search-box]') .
                    Html::tag('div', '[job-of-the-day title="Việc làm mới nhất" subtitle="Khám phá các loại công việc hiện có khác nhau để ứng tuyển, khám phá xem công việc nào phù hợp với bạn." job_categories="1,2,3,4,5,6,8,7" style="style-3"][/job-of-the-day]') .
                    Html::tag('div', '[featured-job-categories title="Xem theo danh mục" subtitle="Tìm công việc phù hợp với bạn. khoảng hơn 800 công việc mới mỗi ngày" limit_category="10" background_image="pages/bg-cat.png" style="style-2"][/featured-job-categories]') .
                    Html::tag('div', '[[testimonials title="Xem một vài từ" description="Hàng ngàn nhân viên có được công việc lý tưởng của họ và phản hồi lại cho chúng tôi!" style="style-2"][/testimonials]') .
                    Html::tag('div', '[our-partners title="Được tin tưởng bởi" name_1="Asus" url_1="https://www.asus.com" image_1="our-partners/asus.png" name_2="Dell" url_2="https://www.dell.com" image_2="our-partners/dell.png" name_3="Microsoft" url_3="https://www.microsoft.com" image_3="our-partners/microsoft.png" name_4="Acer" url_4="https://www.acer.com" image_4="our-partners/acer.png" name_5="Nokia" url_5="https://www.nokia.com" image_5="our-partners/nokia.png"][/our-partners]') .
                    Html::tag('div', '[popular-category title="Danh mục phổ biến" subtitle="Tìm kiếm và kết nối với các ứng viên phù hợp nhanh hơn."][/popular-category]') .
                    Html::tag('div', '[job-by-location title="Việc làm theo địa điểm" description="Tìm công việc yêu thích của bạn và nhận được những lợi ích của chính mình" city="12,46,69,111,121,116,62" style="style-2"][/job-by-location]') .
                    Html::tag('div', '[news-and-blogs title="Tin tức và Blog" subtitle="Nhận tin tức, cập nhật và mẹo mới nhất" button_text="Tải thêm bài viết" button_link="#"][/news-and-blogs]')
                ,
            ],
            [
                'name' => 'Trang chủ 5',
                'content' =>
                    Html::tag('div', '[search-box title="Tìm việc, &#x3C;br&#x3E; Thuê Quảng cáo" description="Mỗi tháng, hơn 3 triệu người tìm việc truy cập trang web để tìm việc, thực hiện hơn 140.000 đơn đăng ký mỗi ngày" banner_image_1="pages/banner1.png" banner_image_2="pages/banner2.png" banner_image_3="pages/banner3.png" banner_image_4="pages/banner4.png" banner_image_5="pages/banner5.png" banner_image_6="pages/banner6.png" style="style-5"][/search-box]') .
                    Html::tag('div', '[counter-section counter_title_1="Trường hợp đã hoàn thành" counter_description_1="Chúng tôi luôn cung cấp cho mọi người một giải pháp hoàn chỉnh dựa trên trọng tâm của bất kỳ doanh nghiệp nào" counter_number_1="1000" counter_title_2="Công ty của chúng tôi" counter_description_2="Chúng tôi luôn cung cấp cho mọi người giải pháp hoàn chỉnh dựa trên trọng tâm của bất kỳ hoạt động kinh doanh nào" counter_number_2="1" counter_title_3="Đào tạo mọi người" counter_description_3="Chúng tôi luôn cung cấp cho mọi người một giải pháp hoàn chỉnh dựa trên trọng tâm của bất kỳ doanh nghiệp nào" counter_number_3="6" counter_title_4="Khách hàng" counter_description_4="Chúng tôi luôn cung cấp cho mọi người một giải pháp hoàn chỉnh dựa trên trọng tâm của bất kỳ doanh nghiệp nào" counter_number_4="2"][/counter-section]') .
                    Html::tag('div', '[popular-category title="Explore the Marketplace" subtitle="Search and connect with the right candidates faster. Tell us what you’ve looking for and we’ll get to work for you." style="style-5"][/popular-category]') .
                    Html::tag('div', '[job-of-the-day title="Việc làm mới nhất" subtitle="Explore the different types of available jobs to apply &#x3C;br&#x3E; discover which is right for you." job_categories="1,2,5,4,7,8" style="style-2"][/job-of-the-day]') .
                    Html::tag('div', '[job-grid style="style-2" title="Tạo tài khoản cá nhân của bạn" subtitle="Tạo tài khoản" description="Hồ sơ công việc là một đánh giá tính cách đo lường tính cách công việc của một cá nhân thông qua các đặc điểm nơi làm việc, các đặc điểm xã hội và cảm xúc của họ; cũng như các giá trị và nguyện vọng thúc đẩy họ tiến về phía trước." image="pages/img-profile.png" button_text="Tạo tài khoản" button_url="/register"][/job-grid]') .
                    Html::tag('div', '[how-it-works title="Cách nó hoạt động" description="Chỉ qua vài thao tác đơn giản, bạn sẽ tìm thấy những ứng viên lý tưởng mà mình đang tìm kiếm!" step_label_1="Đăng ký một &#x3C;br&#x3E; tài khoản để bắt đầu" step_help_1="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do" step_label_2="Khám phá &#x3C;br&#x3E; hàng ngàn hồ sơ" step_help_2="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do" step_label_3="Tìm &#x3C;br&#x3E; ứng cử viên phù hợp nhất" step_help_3="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do" button_label="Bắt đầu ngay" button_url="#"][/how-it-works]') .
                    Html::tag('div', '[top-candidates title="Ứng viên hàng đầu" description="Việc làm là một bảng tuyển dụng tuyển chọn các công việc tốt nhất dành cho nhà phát triển, nhà thiết kế &#x3C;br&#x3E; và các nhà tiếp thị trong ngành công nghệ." limit="8" style="style-5"][/top-candidates]') .
                    Html::tag('div', '[news-and-blogs title="Tin tức và Blog" subtitle="Nhận tin tức, cập nhật và mẹo mới nhất" button_text="Tải thêm bài viết" button_link="#" style="style-2"][/news-and-blogs]')
                ,
            ],
            [
                'name' => 'Trang chủ 6',
                'content' =>
                    Html::tag('div', '[search-box title="Có 102.256 bài đăng ở đây dành cho bạn!" highlight_text="102,256" description="Tìm Việc Làm, Việc Làm & Cơ Hội Nghề Nghiệp" style="style-4" trending_keywords="Design,Development,Manager,Senior,," background_color="#000"][/search-box]') .
                    Html::tag('div', '[gallery image_1="galleries/1.jpg" image_2="galleries/2.jpg" image_3="galleries/3.jpg" image_4="galleries/4.jpg" image_5="galleries/5.jpg" ][/gallery]') .
                    Html::tag('div', '[featured-job-categories title="Browse by category" subtitle="Find the job that’s perfect for you. about 800+ new jobs everyday"][/featured-job-categories]') .
                    Html::tag('div', '[job-grid style="style-2" title="Tạo tài khoản cá nhân của bạn" subtitle="Tạo tài khoản" description="Hồ sơ công việc là một đánh giá tính cách đo lường tính cách công việc của một cá nhân thông qua các đặc điểm nơi làm việc, các đặc điểm xã hội và cảm xúc của họ; cũng như các giá trị và nguyện vọng thúc đẩy họ tiến về phía trước." image="pages/img-profile.png" button_text="Tạo tài khoản" button_url="/register"][/job-grid]') .
                    Html::tag('div', '[job-of-the-day title="Việc làm mới nhất" subtitle="Explore the different types of available jobs to apply discover which is right for you." job_categories="1,2,3,4,5,6" style="style-2"][/job-of-the-day]') .
                    Html::tag('div', '[job-search-banner title="Tìm việc cho người đam mê khởi nghiệp" background_image="pages/img-job-search.png" checkbox_title_1="Tạo tài khoản" checkbox_description_1="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec justo a quam varius maximus. Maecenas sodales tortor quis tincidunt commodo." checkbox_title_2="Tìm kiếm việc làm" checkbox_description_2="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec justo a quam varius maximus. Maecenas sodales tortor quis tincidunt commodo." checkbox_title_3="Lưu & Ứng tuyển" checkbox_description_3="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec justo a quam varius maximus. Maecenas sodales tortor quis tincidunt commodo."][/job-search-banner]')
                ,
            ],
            [
                'name' => 'Việc làm',
                'content' =>
                    Html::tag('div', '[search-box title="Trang web Việc làm CNTT chính thức" highlight_text="Việc làm CNTT" description="“JobBox là điểm dừng đầu tiên của chúng tôi bất cứ khi nào chúng tôi đang tuyển dụng vai trò PHP. Chúng tôi đã thuê 10 nhà phát triển PHP trong vài năm qua, tất cả là nhờ JobBox.” — Andrew Hall, Công ty cổ phần Elite." banner_image_1="pages/left-job-head.png" banner_image_2="pages/right-job-head.png" style="style-3" background_color="#000"][/search-box]') .
                    Html::tag('div', '[job-list max_salary_range="100000"][/job-list]')
                ,
            ],
            [
                'name' => 'Công ty',
                'content' =>
                    Html::tag('div', '[job-companies title="Xem công ty" subtitle="Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero repellendus magni, atque delectus molestias quis?"][/job-companies]')
                ,
            ],
            [
                'name' => 'Ứng viên',
                'content' =>
                    Html::tag('div', '[job-candidates title="Xem ứng viên" description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero repellendus magni, atque &#x3C;br&#x3E; delectus molestias quis?" number_per_page="9" style="grid"][/job-candidates]') .
                    Html::tag('div', '[news-and-blogs title="Tin tức và blog" subtitle="Nhận tin tức, cập nhật và mẹo mới nhất" style="style-2"][/news-and-blogs]')
                ,
            ],
            [
                'name' => 'Giới thiệu',
                'content' =>
                    Html::tag('div', '[company-about title="Giới thiệu về công ty" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ligula ante, dictum non aliquet eu, dapibus ac quam. Morbi vel ante viverra orci tincidunt tempor eu id ipsum. Sed consectetur, risus a blandit tempor, velit magna pellentesque risus, at congue tellus dui quis nisl." title_box="Chúng tôi có thể làm gì?" image="general/img-about2.png" description_box="Aenean sollicituin, lorem quis bibendum auctor nisi elit consequat ipsum sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet maurisorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctora ornare odio. Aenean sollicituin, lorem quis bibendum auctor nisi elit consequat ipsum sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet maurisorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctora ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis non nisi purus. Integer sit nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis non nisi purus. Integer sit nostra, per inceptos himenaeos." url="/" text_button_box="Xem thêm"][/company-about]') .
                    Html::tag('div', '[team title="Giới thiệu về công ty" sub_title="Về công ty" description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ligula ante, dictum non aliquet eu, dapibus ac quam. Morbi vel ante viverra orci tincidunt tempor eu id ipsum. Sed consectetur, risus a blandit tempor, velit magna pellentesque risus, at congue tellus dui quis nisl." number_of_people="8"][/team]') .
                    Html::tag('div', '[news-and-blogs title="Tin tức và blog" subtitle="Nhận tin tức, cập nhật và mẹo mới nhất" button_text="Xem thêm" button_link="/blog" style="style-2"][/news-and-blogs]') .
                    Html::tag('div', '[testimonials title="Khách hàng của chúng tôi" description="Khi nói đến việc chọn đúng nhà cung cấp dịch vụ lưu trữ web, chúng tôi biết việc dễ dàng bị choáng ngợp với số lượng."][/testimonials]')
                ,
            ],
            [
                'name' => 'Bảng giá',
                'content' =>
                    Html::tag('div', '[pricing-table title="Bảng giá" subtitle="Chọn gói tốt nhất dành cho bạn" number_of_package="3"][/pricing-table]') .
                    Html::tag('div', '[faq title="Các câu hỏi thường gặp" subtitle="Aliquam a augue suscipit, luctus neque purus ipsum neque dolor primis a libero tempus, blandit and cursus varius and magnis sapien" number_of_faq="4"][/faq]') .
                    Html::tag('div', '[testimonials title="Khách hàng của chúng tôi" subtitle="Khi nói đến việc chọn đúng nhà cung cấp dịch vụ lưu trữ web, chúng tôi biết việc dễ dàng bị choáng ngợp với số lượng."][/testimonials]')
                ,
            ],
            [
                'name' => 'Liên hệ',
                'content' =>
                    Html::tag('div', '[contact-form title="Liên lạc" subtitle="Bắt đầu làm việc với JobBox có thể cung cấp mọi thứ bạn cần để tạo nhận thức, thúc đẩy lưu lượng truy cập, kết nối." image="general/contact.png" email="contactus@JobBox.com" address="2453 Clinton StreetLittle Rock, California, USA" phone="(+245) 223 1245"][/contact-form]') .
                    Html::tag(
                        'div',
                        '[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]'
                    )
                ,
            ],
            [
                'name' => 'Tin tức',
                'content' => '---',
            ],
            [
                'name' => 'Chính Sách Cookie',
                'content' => Html::tag('h3', 'Sự Đồng Ý Về Cookie Của EU') .
                    Html::tag(
                        'p',
                        'Để sử dụng trang web này, chúng tôi đang sử dụng Cookie và thu thập một số Dữ liệu. Để tuân thủ GDPR của Liên minh Châu Âu, chúng tôi cho bạn lựa chọn nếu bạn cho phép chúng tôi sử dụng một số Cookie nhất định và thu thập một số Dữ liệu.'
                    ) .
                    Html::tag('h4', 'Dữ liệu cần thiết') .
                    Html::tag(
                        'ul',
                        Html::tag(
                            'li',
                            'Dữ liệu cần thiết là cần thiết để chạy Trang web bạn đang truy cập về mặt kỹ thuật. Bạn không thể hủy kích hoạt chúng.'
                        ) .
                        Html::tag(
                            'li',
                            'Session Cookie: PHP sử dụng Cookie để xác định phiên của người dùng. Nếu không có Cookie này, trang web sẽ không hoạt động.'
                        ) .
                        Html::tag(
                            'li',
                            'XSRF-Token Cookie: Laravel tự động tạo "token" CSRF cho mỗi phiên người dùng đang hoạt động do ứng dụng quản lý. Token này được sử dụng để xác minh rằng người dùng đã xác thực là người thực sự đưa ra yêu cầu đối với ứng dụng.'
                        )
                    )
                ,
            ],
            [
                'name' => 'FAQ',
                'content' => Html::tag('div', '[faq title="Các câu hỏi thường gặp"][/faq]')
                ,
            ],
            [
                'name' => 'Dịch vụ',
            ],
            [
                'name' => 'Điều khoản',
            ],
            [
                'name' => 'Sắp có',
                'content' =>
                    Html::tag('div', '[coming-soon title="Chúng tôi sắp ra mắt..!!" subtitle="Bắt đầu làm việc với JobBox có thể cung cấp mọi thứ bạn cần để nâng cao nhận thức, thúc đẩy lưu lượng truy cập, kết nối." date="' . BaseHelper::formatDate(now()->addMonths(1)) . '" time="00:00" image="general/animat-rocket-color.gif"][/coming-soon]')
                ,
            ],
            [
                'name' => 'Job Categories',
                'content' =>
                    Html::tag('div', '[search-box title="22 việc làm có sẵn ngay bây giờ" highlight_text="22 Jobs" description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero repellendus magni, atque delectus molestias quis?" banner_image_1="pages/left-job-head.png" banner_image_2="pages/right-job-head.png" style="style-3" background_color="#000"][/search-box]') .
                    Html::tag('div', '[popular-category title="Danh mục phổ biến" limit_category="8" style="style-1"][/popular-category]') .
                    Html::tag('div', '[job-categories title="Danh mục" subtitle="Tất cả danh mục" limit_category="8"][/job-categories]')
                ,
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['pages_id'] = $index + 1;

            DB::table('pages_translations')->insert($item);
        }
    }
}
