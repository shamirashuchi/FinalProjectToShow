<?php

use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! theme_option('job_list_page_id')) {
            $page = Page::create([
                'name' => 'Jobs',
                'user_id' => 1,
                'template' => 'default',
                'content' => '[job-list][/job-list]',
            ]);

            Slug::create([
                'reference_type' => Page::class,
                'reference_id' => $page->id,
                'key' => $item['slug'] ?? Str::slug($page->name),
                'prefix' => SlugHelper::getPrefix(Page::class),
            ]);

            theme_option()->setOption('job_list_page_id', $page->id)->saveOptions();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
