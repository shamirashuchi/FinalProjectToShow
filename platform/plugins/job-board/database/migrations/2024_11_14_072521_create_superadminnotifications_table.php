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
        Schema::create('superadminnotifications', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->string('type');
            $table->unsignedBigInteger('superadmin_id');
            $table->unsignedBigInteger('consultant_id');
            $table->unsignedBigInteger('jobseeker_id');
            $table->date('EventDate');
            $table->integer('eventId');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Polymorphic columns
            $table->morphs('notifiable');  // This adds 'notifiable_id' and 'notifiable_type'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('superadminnotifications');
    }
};
