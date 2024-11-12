<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jb_consultant_packages', function (Blueprint $table) {
            $table->after('id', function () use ($table) {
                $table->foreignId('consultant_id')->nullable()->constrained('jb_accounts')->cascadeOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jb_consultant_packages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('consultant_id');
        });
    }
};
