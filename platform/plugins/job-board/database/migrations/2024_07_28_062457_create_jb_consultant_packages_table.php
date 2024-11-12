<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jb_consultant_packages')) {
            Schema::create('jb_consultant_packages', function (Blueprint $table) {
                $table->id();
                $table->string('lang_code')->nullable();
                $table->string('name', 255)->nullable();
                $table->longText('description')->nullable();

                $table->integer('credits');
                $table->integer('currency_id')->unsigned();
                $table->tinyInteger('order')->default(0);
                $table->integer('total_hours')->nullable();
                $table->dateTime('start_time');
                $table->dateTime('end_time');
                $table->string('region')->nullable();
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jb_consultant_packages');
    }
};
