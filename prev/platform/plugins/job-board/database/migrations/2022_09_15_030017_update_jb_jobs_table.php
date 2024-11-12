<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jb_jobs', function (Blueprint $table) {
            $table->dropColumn([
                'uniq_id',
                'is_from_api',
                'job_board',
            ]);
        });

        Schema::create('jb_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('description', 400)->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('jb_jobs_tags', function (Blueprint $table) {
            $table->integer('job_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();

            $table->primary(['job_id', 'tag_id']);
        });

        Schema::create('jb_tags_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->integer('jb_tags_id');
            $table->string('name')->nullable();

            $table->primary(['lang_code', 'jb_tags_id'], 'jb_tags_translations_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jb_jobs', function (Blueprint $table) {
            $table->string('uniq_id', 400)->nullable();
            $table->boolean('is_from_api')->default(false);
            $table->string('job_board', 120)->nullable();
        });

        Schema::dropIfExists('jb_tags');
        Schema::dropIfExists('jb_jobs_tags');
        Schema::dropIfExists('jb_tags_translations');
    }
};
