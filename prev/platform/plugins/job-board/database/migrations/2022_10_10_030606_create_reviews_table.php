<?php

use Botble\Base\Enums\BaseStatusEnum;
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
        Schema::create('jb_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->float('star');
            $table->text('review');
            $table->string('status', 60)->default(BaseStatusEnum::PUBLISHED);
            $table->timestamps();
            $table->index(['account_id', 'company_id', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('js_reviews');
    }
};
