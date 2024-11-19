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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('channel_name');
            $table->string('sender_id');
            $table->string('receiver_id');
            $table->string('superadmin_id');
            $table->text('message');
            $table->unsignedBigInteger('event_id')->nullable(); // Event ID
            $table->timestamp('schedule_start_time')->nullable(); // Start time
            $table->timestamp('schedule_end_time')->nullable(); // End time
            $table->tinyInteger('flag')->default(0); // Flag column
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_systems');
    }
};
