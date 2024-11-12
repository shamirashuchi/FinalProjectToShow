<?php

use Botble\JobBoard\Models\Job;
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
        if (! Schema::hasTable('jb_jobs_types')) {
            Schema::create('jb_jobs_types', function (Blueprint $table) {
                $table->integer('job_id')->unsigned();
                $table->integer('job_type_id')->unsigned();
            });

            $jobs = Job::get();

            foreach ($jobs as $job) {
                $job->jobTypes()->attach($job->job_type_id);
            }

            Schema::table('jb_jobs', function (Blueprint $table) {
                $table->dropColumn('job_type_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jb_jobs_types');
    }
};
