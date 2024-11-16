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
    Schema::table('superadminnotifications', function (Blueprint $table) {
        $table->unsignedBigInteger('notifiable')->nullable(); // or use unsignedInteger() based on your DB design
    });
}

public function down()
{
    Schema::table('superadminnotifications', function (Blueprint $table) {
        $table->dropColumn('notifiable');
    });
}

};
