<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jb_accounts', function (Blueprint $table) {
            $table->boolean('available_for_hiring')->default(true);
            $table->integer('country_id')->unsigned()->default(1)->nullable();
            $table->integer('state_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jb_accounts', function (Blueprint $table) {
            $table->dropColumn(['available_for_hiring', 'country_id', 'state_id', 'city_id']);
        });
    }
};
