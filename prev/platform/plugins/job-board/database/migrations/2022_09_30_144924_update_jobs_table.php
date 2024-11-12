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
            $table->decimal('salary_from', 15)->unsigned()->nullable()->change();
            $table->decimal('salary_to', 15)->unsigned()->nullable()->change();
            $table->date('start_date')->nullable();
            $table->date('application_closing_date')->nullable();
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
            $table->decimal('salary_from', 15, 0)->unsigned()->nullable()->change();
            $table->decimal('salary_to', 15, 0)->unsigned()->nullable()->change();
            $table->dropColumn(['start_date', 'application_closing_date']);
        });
    }
};
